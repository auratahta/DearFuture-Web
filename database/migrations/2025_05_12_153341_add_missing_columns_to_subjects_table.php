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
        Schema::table('subjects', function (Blueprint $table) {
            $table->string('category')->default('General')->after('name');
            $table->string('icon')->nullable()->after('description');
            $table->boolean('is_active')->default(true)->after('icon');
            $table->integer('display_order')->default(0)->after('is_active');
            $table->string('color_code')->nullable()->after('display_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropColumn(['category', 'icon', 'is_active', 'display_order', 'color_code']);
        });
    }
};