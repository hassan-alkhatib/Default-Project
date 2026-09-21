<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->string('item_code')->unique();
            $table->string('name');
            $table->string('name_ar')->nullable();
            $table->enum('category', ['medication', 'equipment', 'supplies', 'consumable'])->default('medication');
            $table->text('description')->nullable();
            $table->integer('quantity')->default(0);
            $table->integer('minimum_stock')->default(10);
            $table->integer('maximum_stock')->default(1000);
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->string('supplier')->nullable();
            $table->string('supplier_phone')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('location')->nullable();
            $table->enum('status', ['in_stock', 'low_stock', 'out_of_stock', 'expired'])->default('in_stock');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory');
    }
};
