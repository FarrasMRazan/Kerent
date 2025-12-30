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
            if (Schema::hasColumn('clothes', 'stok_s')) {
                $table->dropColumn(['stok_s', 'stok_m', 'stok_l', 'stok_xl']);
            }
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
