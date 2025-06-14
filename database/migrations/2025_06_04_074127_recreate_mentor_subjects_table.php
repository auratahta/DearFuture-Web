<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop table yang lama
        Schema::dropIfExists('mentor_subjects');
        
        // Buat ulang dengan struktur yang benar
        Schema::create('mentor_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->decimal('price_per_hour', 10, 2)->default(30000);
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->unique(['mentor_id', 'subject_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mentor_subjects');
    }
};