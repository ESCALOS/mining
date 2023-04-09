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
        Schema::create('laws', function (Blueprint $table) {
            $table->id();
            $table->foreignId('settlement_id')->constrained();
            $table->unsignedDecimal('copper',8,4);
            $table->unsignedDecimal('humidity',8,4);
            $table->unsignedDecimal('decrease',8,4);
            $table->unsignedDecimal('silver',8,4);
            $table->unsignedDecimal('silver_factor',8,4);
            $table->unsignedDecimal('gold',8,4);
            $table->unsignedDecimal('gold_factor',8,4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laws');
    }
};
