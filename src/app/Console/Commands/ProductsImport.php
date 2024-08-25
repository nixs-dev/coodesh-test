<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use App\Models\Product;
use ErrorException;
use Exception;
use Illuminate\Support\Facades\Log;

class ProductsImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa produtos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Cache::set('last_cronjob_execution', now());

        $file_names_url = 'https://challenges.coode.sh/food/data/json/index.txt';
        $one_file_base_url = 'https://challenges.coode.sh/food/data/json/';
        $max_imports = 100;
        $imports_count = 0;

        try {
            $file_names = array_map(fn($name) => trim($name), explode('<br />', nl2br(file_get_contents($file_names_url))));
            $file_names = array_filter($file_names, fn($name) => $name !== '');
        } catch (ErrorException $exception) {
            Log::error($exception->getMessage());
            return;
        }

        foreach ($file_names as $file) {
            try {
                $stream = gzopen($one_file_base_url . $file, 'rb');
                if ($stream === false) {
                    throw new Exception('Erro ao abrir o arquivo.');
                }

                while (!gzeof($stream) && $imports_count < $max_imports) {
                    $line = gzgets($stream);
                    $product = json_decode($line, true);

                    if (json_last_error() === JSON_ERROR_NONE) {
                        $to_import_product = new Product;

                        $to_import_product->code = intval(str_replace('"', '', $product['code']));
                        $to_import_product->imported_t = now();
                        $to_import_product->url = $product['url'];
                        $to_import_product->creator = $product['creator'];
                        $to_import_product->created_t = date('Y-m-d H:i:s', $product['created_t']);
                        $to_import_product->last_modified_t = date('Y-m-d H:i:s', $product['last_modified_t']);
                        $to_import_product->product_name = $product['product_name'];
                        $to_import_product->quantity = $product['quantity'];
                        $to_import_product->brands = $product['brands'];
                        $to_import_product->categories = $product['categories'];
                        $to_import_product->labels = $product['labels'];
                        $to_import_product->cities = $product['cities'] ?? null;
                        $to_import_product->purchase_places = $product['purchase_places'];
                        $to_import_product->stores = $product['stores'];
                        $to_import_product->ingredients_text = $product['ingredients_text'];
                        $to_import_product->traces = $product['traces'];
                        $to_import_product->serving_size = $product['serving_size'];
                        $to_import_product->serving_quantity = floatval($product['serving_quantity']);
                        $to_import_product->nutriscore_score = intval($product['nutriscore_score']);
                        $to_import_product->nutriscore_grade = $product['nutriscore_grade'];
                        $to_import_product->main_category = $product['main_category'];
                        $to_import_product->image_url = $product['image_url'];

                        if (Product::find($to_import_product->code) == null) {
                            $to_import_product->status = 'published';
                            $to_import_product->save();
                        } else {
                            $to_import_product->update();
                        }

                        $imports_count++;
                    } else {
                        Log::error('Erro ao decodificar a linha JSON: ' . json_last_error_msg());
                    }
                }

                gzclose($stream);

                Log::info("Foram importados $imports_count produtos do arquivo $file");
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
        }
    }
}
