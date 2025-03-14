<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->integer('sort_order')->default(0)->unique();
            $table->foreignId('parent_route_id')->nullable()->constrained('routes')->onDelete('cascade');
            $table->string('key')->unique();
            $table->string('name')->unique()->nullable();
            $table->string('icon')->nullable();
            $table->string('path')->unique()->nullable();
            $table->json('meta')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};
