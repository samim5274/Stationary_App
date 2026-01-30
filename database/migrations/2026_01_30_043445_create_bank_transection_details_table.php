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
        Schema::create('bank_transection_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_id')->constrained('bank_details')->onDelete('restrict');
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');

            $table->decimal('amount', 15, 2); // deposit amount
            $table->date('date');
            $table->string('status'); // e.g., 'deposit', 'withdrawal'
            $table->text('remarks')->default('N/A');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_transection_details');
    }
};
