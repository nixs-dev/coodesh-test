<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigInteger('code')->primary();
            $table->string('status');
            $table->timestamp('imported_t')->nullable();
            $table->string('url');
            $table->string('creator');
            $table->timestamp('created_t')->nullable();
            $table->timestamp('last_modified_t')->nullable();
            $table->string('product_name');
            $table->string('quantity');
            $table->string('brands');
            $table->string('categories');
            $table->string('labels');
            $table->string('cities')->nullable();
            $table->string('purchase_places');
            $table->string('stores');
            $table->text('ingredients_text');
            $table->text('traces');
            $table->string('serving_size');
            $table->float('serving_quantity');
            $table->integer('nutriscore_score');
            $table->string('nutriscore_grade');
            $table->string('main_category');
            $table->string('image_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
