<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('Products', static function (Blueprint $table) {
            $table->id();
            $table->string('title', 500);
            $table->string('code')->unique();
            $table->string('slug');
            $table->double('price')->default(0);
            $table->integer('quantity')->default(0);
            //$table->decimal('price', 6, 2);
            //$table->string('quality');
            $table->string('photo')->nullable();
            $table->string('unit_pricing_base_measure')->nullable();
            $table->string('article')->nullable();
            $table->string('photo_thumb')->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('category_id')->unsigned()->references('id')->on('product_categories')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('Products');
    }
}
