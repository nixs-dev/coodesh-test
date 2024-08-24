<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public static function index(Request $request)
    {
        $products = Product::forPage($request->page ?? 1, 50)->get();

        return response()->json(['success' => true, 'content' => $products]);
    }

    public static function get(int $code)
    {
        $product = Product::findOrFail($code);

        return response()->json(['success' => true, 'content' => $product]);
    }

    public function update(Request $request, $code)
    {
        if ($request->input('code') != $code) {
            return response()->json(['success' => false, 'message' => 'Código inválido!']);
        }

        $to_update_product = Product::findOrFail($code);

        $to_update_product->url = $request->input('url');
        $to_update_product->creator = $request->input('creator');
        $to_update_product->product_name = $request->input('product_name');
        $to_update_product->quantity = intval($request->input('quantity'));
        $to_update_product->brands = $request->input('brands');
        $to_update_product->categories = $request->input('categories');
        $to_update_product->labels = $request->input('labels');
        $to_update_product->cities = $request->input('cities');
        $to_update_product->purchase_places = $request->input('purchase_places');
        $to_update_product->stores = $request->input('stores');
        $to_update_product->ingredients_text = $request->input('ingredients_text');
        $to_update_product->traces = $request->input('traces');
        $to_update_product->serving_size = $request->input('serving_size');
        $to_update_product->serving_quantity = floatval($request->input('serving_quantity'));
        $to_update_product->nutriscore_score = intval($request->input('nutriscore_score'));
        $to_update_product->nutriscore_grade = $request->input('nutriscore_grade');
        $to_update_product->main_category = $request->input('main_category');
        $to_update_product->image_url = $request->input('image_url');

        $to_update_product->save();

        return response()->json(['success' => true, 'content' => null], 200);
    }

    public static function delete(int $code)
    {
        $product = Product::findOrFail($code);
        $product->status = 'trash';

        $product->update();

        return response()->json(['success' => true, 'content' => null]);
    }
}
