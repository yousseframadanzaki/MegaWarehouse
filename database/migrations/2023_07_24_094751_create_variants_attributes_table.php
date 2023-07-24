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
        Schema::create('variants_attributes', function (Blueprint $table) {
            $table->string('value');

            $table->unsignedBiginteger('variant_id');
            $table->unsignedBiginteger('attribute_id');
            $table->primary(['variant_id','attribute_id']);
            $table->foreign('variant_id')->references('id')
                 ->on('variants')->onDelete('cascade');
            $table->foreign('attribute_id')->references('id')
                ->on('attributes')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variants_attributes');
    }
};
