<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('ten_ngan_hang')->nullable();
            $table->string('stk_ngan_hang')->nullable();
            $table->string('vi_dien_tu')->nullable();
            $table->string('vi_dien_tu_sdt')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'ten_ngan_hang', 
                'stk_ngan_hang', 
                'vi_dien_tu', 
                'vi_dien_tu_sdt' // Add this missing column here
            ]);
        });
    }
};