<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('specialization');
            $table->string('license_number')->unique();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('biography')->nullable();
            $table->decimal('consultation_fee', 8, 2)->default(0);
            $table->enum('status', ['active', 'on_leave', 'inactive'])->default('active');
            $table->string('schedule')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
