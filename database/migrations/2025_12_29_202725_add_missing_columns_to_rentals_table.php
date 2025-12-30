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
        Schema::table('rentals', function (Blueprint $table) {
            // Menambahkan kolom yang hilang
            if (!Schema::hasColumn('rentals', 'end_date')) {
                $table->date('end_date')->nullable()->after('start_date');
            }
            
            if (!Schema::hasColumn('rentals', 'penalty_fee')) {
                $table->integer('penalty_fee')->default(0)->after('current_lng');
            }
        });
    }

    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropColumn(['end_date', 'penalty_fee']);
        });
    }
};
