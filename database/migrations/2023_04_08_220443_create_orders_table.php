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
            $table->string('batch',9)->unique();
            $table->string('ticket')->unique();
            $table->foreignId('client_id')->constrained();
            $table->foreignId('concentrate_id')->constrained();
            $table->unsignedDecimal('wmt',8,4); //wet metric tonne
            $table->string('origin');
            $table->unsignedBigInteger('carriage_company_id');
            $table->foreign('carriage_company_id')->references('id')->on('entities')->onDelete('restrict');
            $table->string('plate_number',6);
            $table->string('transport_guide',30);
            $table->string('delivery_note',30);
            $table->unsignedBigInteger('weighing_scale_company_id');
            $table->foreign('weighing_scale_company_id')->references('id')->on('entities')->onDelete('restrict');
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
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
