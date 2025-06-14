<?php

// Isi file database/migrations/2025_04_12_152108_create_mentor_subjects_table.php
// dengan konten ini:

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
        Schema::create('mentor_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->decimal('price_per_hour', 10, 2)->default(30000);
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Unique constraint to prevent duplicate mentor-subject pairs
            $table->unique(['mentor_id', 'subject_id']);
            
            // Indexes
            $table->index(['mentor_id', 'is_active']);
            $table->index(['subject_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mentor_subjects');
    }
};