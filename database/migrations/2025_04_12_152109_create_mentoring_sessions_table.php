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
        Schema::create('mentoring_sessions', function (Blueprint $table) {
            $table->id();
            
            // Foreign Keys - student_id bisa nullable untuk availability slots
            $table->foreignId('student_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('mentor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            
            // Session Details
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->decimal('price', 10, 2)->default(30000);
            
            // Status & Notes - tambah 'available' dan 'booked'
            $table->enum('status', [
                'available',   // Available slot for booking (admin created)
                'booked',      // Student booked but not paid yet
                'pending',     // Pending payment confirmation
                'confirmed',   // Confirmed and paid
                'ongoing',     // Session is happening
                'completed',   // Session finished
                'cancelled'    // Session cancelled
            ])->default('available');
            
            $table->text('notes')->nullable();
            $table->text('student_notes')->nullable();
            $table->text('mentor_notes')->nullable();
            
            // Meeting Details
            $table->string('meeting_link')->nullable();
            $table->timestamp('meeting_started_at')->nullable();
            $table->timestamp('meeting_ended_at')->nullable();
            
            // Feedback & Rating
            $table->tinyInteger('rating')->nullable(); // 1-5 scale
            $table->text('feedback')->nullable();
            
            // Additional Info
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->text('reschedule_reason')->nullable();
            
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['student_id', 'date']);
            $table->index(['mentor_id', 'date']);
            $table->index(['status', 'date']);
            $table->index(['date', 'start_time']);
            $table->index(['status', 'student_id']); // untuk filter available slots
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mentoring_sessions');
    }
};