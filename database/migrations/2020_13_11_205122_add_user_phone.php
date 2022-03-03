<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserPhone extends Migration
{
    public function up(): void
    {
        Schema::table('users', static function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('phone_verified_status')->default(\App\Models\User::STATUS_WAIT)->after('phone');
            $table->string('phone_verify_token')->nullable()->after('remember_token');
            $table->timestamp('phone_verify_token_expire')->nullable()->after('phone_verify_token');
        });
    }

    public function down(): void
    {
        Schema::table('users', static function (Blueprint $table) {
            $table->dropColumn('phone_verify_token_expire');
            $table->dropColumn('phone_verify_token');
            $table->dropColumn('phone_verified_status');
            $table->dropColumn('phone');
        });
    }
}
