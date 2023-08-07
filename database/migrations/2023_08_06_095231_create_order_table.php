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
            $table->string('name');
            $table->string('phone_1');
            $table->string('phone_2')->nullable();
            $table->string('address');
            $table->string('country_id');
            $table->string('city_id');
            $table->string('area_id');
            $table->float('total');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('company_id');

            $table->foreign('company_id')->references('id')
                 ->on('companies');
            $table->foreign('admin_id')->references('id')
                 ->on('users');
            $table->foreign('client_id')->references('id')
                 ->on('clients');

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
