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
        Schema::create('pdr_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('pdr_categories')->onDelete('restrict');
            $table->string('name', 120)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pdr_sub_categories');
    }
};
