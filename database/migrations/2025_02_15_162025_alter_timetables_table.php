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
        Schema::table('timetables', function (Blueprint $table) {
            // Pehle foreign key constraints drop karein
            $table->dropForeign(['class_id']);
            $table->dropForeign(['day_id']);
            $table->dropForeign(['subject_id']);

            // Ab columns ko nullable banayein
            $table->foreignId('class_id')->nullable()->change();
            $table->foreignId('day_id')->nullable()->change();
            $table->foreignId('subject_id')->nullable()->change();

            // Phir wapas constraints add karein
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('day_id')->references('id')->on('days')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');

            // Baaki fields update karein
            $table->string('start_time')->nullable()->change();
            $table->string('end_time')->nullable()->change();
            $table->string('room_no')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('timetables', function (Blueprint $table) {
            // Pehle foreign key constraints drop karein
            $table->dropForeign(['class_id']);
            $table->dropForeign(['day_id']);
            $table->dropForeign(['subject_id']);

            // Nullable remove karein (nullable hata kar default NOT NULL bana dega)
            $table->foreignId('class_id')->nullable(false)->change();
            $table->foreignId('day_id')->nullable(false)->change();
            $table->foreignId('subject_id')->nullable(false)->change();

            // Phir wapas constraints add karein
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('day_id')->references('id')->on('days')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');

            // Baaki fields ko NOT NULL karein
            $table->string('start_time')->nullable(false)->change();
            $table->string('end_time')->nullable(false)->change();
            $table->string('room_no')->nullable(false)->change();
        });
    }
};
