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
        Schema::create('payment_details', function (Blueprint $table) {
            $table->id();

            $table->date('date');

            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('order_id')->constrained('orders')->onDelete('restrict');
            
            $table->unsignedBigInteger('reg')->unique();

            $table->decimal('total', 12, 2)->nullable();
            $table->decimal('discount', 12, 2)->nullable();
            $table->decimal('vat', 12, 2)->nullable();
            $table->decimal('payable', 12, 2)->nullable();
            $table->decimal('pay', 12, 2)->nullable();
            $table->decimal('due', 12, 2)->nullable();

            $table->foreignId('payment_method_id')->constrained('payment_methods')->onDelete('restrict');
            
            $table->timestamps();

            $table->index(['date', 'user_id', 'order_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_details');
    }
};
