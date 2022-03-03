<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->references('id')->on('products')->onDelete('CASCADE');
            $table->bigInteger('category_id')->references('id')->on('product_categories')->onDelete('CASCADE');
            $table->bigInteger('sub_category_id');
            $table->bigInteger('product_property_id')->references('id')->on('product_properties')->onDelete('CASCADE');
            $table->bigInteger('product_property_value_id')->references('id')->on('product_property_values')->onDelete('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_attributes');
    }
}
