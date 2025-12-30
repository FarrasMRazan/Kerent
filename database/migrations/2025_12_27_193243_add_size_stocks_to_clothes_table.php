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
        Schema::table('clothes', function (Blueprint $table) {
            $table->integer('stok_s')->default(0);
            $table->integer('stok_m')->default(0);
            $table->integer('stok_l')->default(0);
            $table->integer('stok_xl')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clothes', function (Blueprint $table) {
            //
        });
    }
};
