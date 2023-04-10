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
        Schema::create('penalty_totals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('settlement_id')->constrained();
            $table->decimal('leftover_arsenic',8,4);
            $table->decimal('leftover_antomony',8,4);
            $table->decimal('leftover_lead',8,4);
            $table->decimal('leftover_zinc',8,4);
            $table->decimal('leftover_bismuth',8,4);
            $table->decimal('leftover_mercury',8,4);
            $table->decimal('total_arsenic',8,4);
            $table->decimal('total_antomony',8,4);
            $table->decimal('total_lead',8,4);
            $table->decimal('total_zinc',8,4);
            $table->decimal('total_bismuth',8,4);
            $table->decimal('total_mercury',8,4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penalty_totals');
    }
};
