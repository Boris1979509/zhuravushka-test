<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeColumnParentIdBlogCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('blog_categories', function (Blueprint $table) {
            $table->integer('parent_id')->default(null)->nullable()->change();
        });
        DB::table('blog_categories')->update([
            'parent_id' => null,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('blog_categories', function (Blueprint $table) {
            //
        });
    }
}
