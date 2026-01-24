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
        Schema::create('pdr_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('restrict');

            $table->string('ref', 60)->nullable(); // e.g. PO-1001 / SALE-2002
            $table->date('date');

            $table->enum('type', ['IN', 'OUT', 'ADJUST'])->default('IN');
            $table->unsignedInteger('qty')->default(0);

            $table->string('remark', 255)->nullable();

            $table->string('created_by')->nullable(); // user_id/admin_id
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pdr_stocks');
    }
};
