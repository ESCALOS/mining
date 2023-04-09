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
        Schema::create('allowed_amounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('settlement_id')->constrained();
            $table->unsignedDecimal('arsenic',8,4);
            $table->unsignedDecimal('antomony',8,4);
            $table->unsignedDecimal('lead',8,4);
            $table->unsignedDecimal('zinc',8,4);
            $table->unsignedDecimal('bismuth',8,4);
            $table->unsignedDecimal('mercury',8,4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allowed_amounts');
    }
};
