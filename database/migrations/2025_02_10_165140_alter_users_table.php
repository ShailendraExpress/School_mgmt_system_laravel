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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('class_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('academic_year_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('admission_date')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mobno')->nullable();
            $table->string('dob')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign key constraints first
            $table->dropForeign(['class_id']);
            $table->dropForeign(['academic_year_id']);

            // Drop the columns
            $table->dropColumn('class_id');
            $table->dropColumn('academic_year_id');
            $table->dropColumn('admission_date');
            $table->dropColumn('father_name');
            $table->dropColumn('mother_name');
            $table->dropColumn('mobno');
            $table->dropColumn('dob');
        });
    }
};
