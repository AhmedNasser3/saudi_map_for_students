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
        Schema::table('land_areas', function (Blueprint $table) {
            $table->foreignId('highest_bidder_id')->nullable()->constrained('users')->onDelete('set null'); // المزايد الأعلى
            $table->decimal('highest_bid', 15, 2)->nullable(); // المزايدة الأعلى
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('land_areas', function (Blueprint $table) {
            //
        });
    }
};
