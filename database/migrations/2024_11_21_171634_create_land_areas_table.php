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
        Schema::create('land_areas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('land_id')->constrained()->onDelete('cascade'); // المدينة
            $table->decimal('area', 10, 2); // المساحة بالمتر
            $table->decimal('starting_price', 15, 2); // السعر المبدئي
            $table->timestamp('auction_end_time'); // وقت انتهاء المزاد
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // المشتري
            $table->decimal('final_price', 15, 2)->nullable(); // السعر النهائي
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('land_areas');
    }
};
