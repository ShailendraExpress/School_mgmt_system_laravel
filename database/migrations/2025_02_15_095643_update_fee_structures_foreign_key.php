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
        Schema::table('fee_structures', function (Blueprint $table) {
            // Pehle existing foreign keys delete karein
            $table->dropForeign(['class_id']);
            $table->dropForeign(['academic_year_id']);
            $table->dropForeign(['fee_head_id']);
    
            // Fir naye constraints add karein
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('cascade');
            $table->foreign('fee_head_id')->references('id')->on('fee_heads')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fee_structures', function (Blueprint $table) {
            $table->dropForeign(['class_id']);
            $table->dropForeign(['academic_year_id']);
            $table->dropForeign(['fee_head_id']);
        });
    }
};
