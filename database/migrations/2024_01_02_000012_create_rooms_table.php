<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_number')->unique();
            $table->foreignId('department_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['ward', 'private', 'icu', 'emergency', 'operating', 'laboratory', 'pharmacy'])->default('ward');
            $table->integer('capacity')->default(1);
            $table->integer('current_occupancy')->default(0);
            $table->decimal('rate_per_day', 8, 2)->default(0);
            $table->enum('status', ['available', 'occupied', 'maintenance', 'reserved'])->default('available');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
