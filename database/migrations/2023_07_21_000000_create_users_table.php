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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone_1')->unique();
            $table->string('password');
            $table->boolean('active')->default(1);
            $table->boolean('is_admin')->default(0);
            $table->unsignedBiginteger('company_id')->nullable();
            $table->unsignedBiginteger('warehouse_id')->nullable();
            $table->unsignedBiginteger('role_id');

            $table->foreign('role_id')->references('id')
                 ->on('roles');
            $table->foreign('company_id')->references('id')
                 ->on('companies');
            $table->foreign('warehouse_id')->references('id')
                 ->on('warehouses');

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
