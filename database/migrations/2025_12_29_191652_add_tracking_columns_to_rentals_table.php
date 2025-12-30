<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('rentals', function (Blueprint $table) {
            $table->text('user_address')->nullable(); 
            $table->double('user_lat')->nullable(); 
            $table->double('user_lng')->nullable(); 
            $table->double('current_lat')->nullable(); 
            $table->double('current_lng')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            //
        });
    }
};
