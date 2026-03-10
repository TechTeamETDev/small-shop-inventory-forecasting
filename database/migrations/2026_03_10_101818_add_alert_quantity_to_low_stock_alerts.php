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
        Schema::table('low_stock_alerts', function (Blueprint $table) {
            //
            Schema::table('low_stock_alerts', function (Blueprint $table) {
    $table->integer('alert_quantity')->after('product_id');
});
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('low_stock_alerts', function (Blueprint $table) {
            //
        });
    }
};
