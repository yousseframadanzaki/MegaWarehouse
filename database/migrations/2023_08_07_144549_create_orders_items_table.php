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
        Schema::create('orders_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('orders_id')->unsigned();
            $table->unsignedBiginteger('variants_id')->unsigned();
            $table->unsignedInteger('quantity');
            $table->unsignedBiginteger('warehouse_id');
            $table->foreign('orders_id')->references('id')
                 ->on('orders');
            $table->foreign('variants_id')->references('id')
                ->on('variants');
            $table->foreign('warehouse_id')->references('id')
                ->on('warehouses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_items');
    }
};
