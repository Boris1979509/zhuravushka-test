<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsComparesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('product_compares', function (Blueprint $table) {
            $table->integer('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->integer('product_id')->references('id')->on('Products')->onDelete('CASCADE');
            $table->primary(['user_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('product_compares');
    }
}
