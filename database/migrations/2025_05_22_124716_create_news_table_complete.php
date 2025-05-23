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
        // Drop table jika sudah ada tapi tidak lengkap
        Schema::dropIfExists('news');
        
        // Buat tabel news yang lengkap
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('category', ['announcements', 'events', 'academic']);
            $table->text('excerpt');
            $table->longText('content');
            $table->string('image')->nullable();
            $table->enum('status', ['published', 'draft'])->default('draft');
            $table->datetime('publish_date')->nullable();
            $table->unsignedBigInteger('author_id');
            $table->boolean('featured')->default(false);
            $table->json('tags')->nullable();
            $table->unsignedBigInteger('views')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes untuk performance
            $table->index(['status', 'publish_date']);
            $table->index('category');
            $table->index('featured');
            $table->index('author_id');
            
            // Foreign key constraint - uncomment jika tabel users sudah ada
            // $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};