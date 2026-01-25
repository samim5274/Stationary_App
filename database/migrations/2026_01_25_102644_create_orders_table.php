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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->date('date');

            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
            
            $table->unsignedBigInteger('reg')->unique();
            $table->decimal('total', 12, 2)->nullable();
            $table->Integer('status')->default(0); // 0=pending,1=paid,2=cancel etc

            $table->string('customerName')->default("Guest User");
            $table->string('customerPhone')->default(0);

            $table->timestamps();

            $table->index(['date', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
