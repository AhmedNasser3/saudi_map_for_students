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
        Schema::create('expand_areas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('number_products');
            $table->decimal('area', 10, 2)->nullable();
            $table->decimal('bonus_area_price', 10, 2)->nullable();
            $table->string('state')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expand_areas');
    }
};
