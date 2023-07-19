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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('phone_1');
            $table->string('phone_2')->nullable();
            $table->string('address');
            $table->unsignedBigInteger('area_id');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('client_group_id')->nullable();
            $table->json('links')->nullable();

            $table->foreign('company_id')
            ->references('id')->on('companies');
            $table->foreign('client_group_id')
            ->references('id')->on('client_groups');
            $table->foreign('area_id')
            ->references('id')->on('areas');
            $table->foreign('city_id')
            ->references('id')->on('cities');
            $table->foreign('country_id')
            ->references('id')->on('countries');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
