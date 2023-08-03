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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('warehouse_id');
            $table->unsignedBigInteger('variant_id');
            $table->unsignedBigInteger('order_id')->nullable();

            $table->Integer('quantity');
            $table->string('note')->nullable();
            $table->enum('type', array('move','buy','sell','returned_orders','returned_suppliers'));

            $table->foreign('variant_id')->references('id')
                 ->on('variants');
            $table->foreign('company_id')->references('id')
                 ->on('companies');
            $table->foreign('admin_id')->references('id')
                 ->on('users');
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
        Schema::dropIfExists('stocks');
    }
};
