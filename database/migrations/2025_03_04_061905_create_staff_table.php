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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->nullable()->constrained('staff');
            $table->foreignId('manager_id')->nullable()->constrained('staff');
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('password');
            $table->string('role')->default('user');
            $table->string('status')->default('active');
            $table->foreignId('domain_id')->nullable();
            $table->decimal('payout', 10, 2)->default(0);
            $table->string('skype')->nullable();
            $table->text('description')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->boolean('notification')->default(true);
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
