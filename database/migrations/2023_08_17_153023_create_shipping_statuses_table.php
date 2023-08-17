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
        Schema::create('shipping_statuses', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('status_id')->nullable();
            $table->unsignedBigInteger('shipping_company_status_id');
            $table->unsignedBigInteger('shipping_company_id');

            $table->foreign('status_id')->references('id')->on('statuses');
            $table->foreign('shipping_company_id')->references('id')->on('shipping_companies');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_statuses');
    }
};
