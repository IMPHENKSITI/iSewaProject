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
        // Fix Notifications Type - Change to String to allow any type
        Schema::table('notifications', function (Blueprint $table) {
            $table->string('type')->change();
        });

        // Add Soft Deletes to Rental Bookings
        Schema::table('rental_bookings', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add Soft Deletes to Gas Orders
        Schema::table('gas_orders', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We cannot easily revert enum changes without raw SQL and knowing previous state strictly, 
        // but generally we don't need to revert 'string' back to 'enum' for strictness in this context.
        
        Schema::table('rental_bookings', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('gas_orders', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
