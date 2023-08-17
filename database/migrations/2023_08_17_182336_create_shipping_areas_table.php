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
        Schema::create('shipping_areas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('area_id')->nullable();
            $table->unsignedBigInteger('shipping_company_sector_id');
            $table->unsignedBigInteger('shipping_company_id');
            $table->foreign('area_id')->references('id')->on('areas');
            $table->foreign('shipping_company_id')->references('id')->on('shipping_companies');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_areas');
    }
};
