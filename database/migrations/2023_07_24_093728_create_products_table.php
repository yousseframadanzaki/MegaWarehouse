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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description');
            $table->float('cost');
            $table->float('price');
            $table->float('sale_price');

            $table->unsignedBiginteger('supplier_id');
            $table->unsignedBiginteger('brand_id');
            $table->unsignedBiginteger('category_id');
            $table->unsignedBiginteger('company_id');

            $table->foreign('supplier_id')->references('id')
                 ->on('suppliers');
            $table->foreign('brand_id')->references('id')
                 ->on('brands');
            $table->foreign('category_id')->references('id')
                 ->on('categories');
            $table->foreign('company_id')->references('id')
                 ->on('companies');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
