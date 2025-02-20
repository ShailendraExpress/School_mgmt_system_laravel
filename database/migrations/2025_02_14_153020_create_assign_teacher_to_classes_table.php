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
        Schema::create('assign_teacher_to_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('Classes')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('Subjects')->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('Users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assign_teacher_to_classes');
    }
};
