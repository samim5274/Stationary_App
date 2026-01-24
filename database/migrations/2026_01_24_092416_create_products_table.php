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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('slug', 255)->unique();
            $table->string('sku', 50)->unique();

            $table->foreignId('category_id')->constrained('pdr_categories')->onDelete('restrict');

            $table->foreignId('subcategory_id')->constrained('pdr_sub_categories')->onDelete('restrict');

            $table->decimal('price', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('cost_price', 12, 2)->nullable();

            $table->unsignedInteger('stock')->default(0);
            $table->unsignedInteger('min_stock')->default(0);

            $table->string('unit', 30)->nullable();   // pcs, kg, liter
            $table->string('size', 60)->nullable();   // 250ml, XL etc.

            $table->string('image')->nullable();

            $table->boolean('availability')->default(true); // in/out stock
            $table->boolean('status')->default(true);       // active/inactive

            $table->date('manufactured_at')->nullable();
            $table->date('expired_at')->nullable();

            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
