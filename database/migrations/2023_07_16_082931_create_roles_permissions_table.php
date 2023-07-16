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
        Schema::create('roles_permissions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBiginteger('roles_id')->unsigned();
            $table->unsignedBiginteger('permissions_id')->unsigned();

            $table->foreign('roles_id')->references('id')
                 ->on('roles')->onDelete('cascade');
            $table->foreign('permissions_id')->references('id')
                ->on('permissions')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles_permissions');
    }
};
