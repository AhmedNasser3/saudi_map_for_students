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
            $table->foreignId('land_id')->constrained()->onDelete('cascade')->nullable();
            $table->decimal('area', 10, 2)->nullable();
            $table->decimal('starting_price', 15, 2)->nullable();
            $table->timestamp('auction_end_time')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('final_price', 15, 2)->nullable();
            $table->string('day')->nullable();
            $table->string('duration')->nullable();
            $table->foreignId('highest_bidder_id')->nullable()->constrained('users')->onDelete('set null')->nullable();
            $table->decimal('highest_bid', 15, 2)->nullable();
            $table->string('tax')->default(0)->nullable();
            $table->timestamp('tax_end_time')->nullable();
            $table->string('state')->default('1')->nullable();
            $table->string('img')->nullable();
            $table->string(column: 'land_deed')->nullable();
            $table->dateTime(column: 'start_time')->nullable();
            $table->dateTime(column: 'before_start_time')->nullable();
            $table->integer('before_show')->default(0);
            $table->boolean('show')->default(true);
            $table->integer('show_to_estate')->default(0);
            $table->integer('add_balance_to_seller')->default(0);
            $table->dateTime(column: 'go_time')->nullable();
            $table->boolean('go')->default(false);
            $table->dateTime(column: 'stop_time')->nullable();
            $table->boolean('stop')->default(false);
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