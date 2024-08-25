<?php

namespace Tests\Unit;

use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_get_product(): void
    {
        $code = 17;
        $product_name = 'Vitória crackers';
        $response = $this->get("/api/products/$code");

        $response->assertJsonPath('content.code', $code);
        $response->assertJsonPath('content.product_name', $product_name);
    }

    public function test_update_product(): void
    {
        $product = [
            'code' => 17,
            'url' => 'http://world-en.openfoodfacts.org/product/0000000000017/vitoria-crackers',
            'creator' => 'kiliweb',
            'product_name' => 'Vitória crackers',
            'quantity' => '',
            'brands' => '',
            'categories' => '',
            'labels' => '',
            'cities' => '',
            'purchase_places' => '',
            'stores' => '',
            'ingredients_text' => '',
            'traces' => '',
            'serving_size' => '',
            'serving_quantity' => 0,
            'nutriscore_score' => 0,
            'nutriscore_grade' => '',
            'main_category' => '',
            'image_url' => 'https://static.openfoodfacts.org/images/products/000/000/000/0017/front_fr.4.400.jpg',
        ];

        $product['quantity'] = '10';

        $response = $this->put("/api/products/". $product['code'], $product);

        $response->assertJsonPath('success', true);

        $updated_product = $this->get("/api/products/" . $product['code']);

        $updated_product->assertJsonPath('content.quantity', $product['quantity']);
    }
}
