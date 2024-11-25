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
            $table->foreignId('land_id')->constrained()->onDelete('cascade');
            $table->decimal('area', 10, 2);
            $table->decimal('starting_price', 15, 2);
            $table->timestamp('auction_end_time');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('final_price', 15, 2)->nullable();
            $table->string('day');
            $table->string('duration');
            $table->foreignId('highest_bidder_id')->nullable()->constrained('users')->onDelete('set null')->nullable();
            $table->decimal('highest_bid', 15, 2)->nullable();
            $table->string('tax')->default(0);
            $table->timestamp('tax_end_time')->nullable();
            $table->string('state')->default('1');
            $table->string('img');

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