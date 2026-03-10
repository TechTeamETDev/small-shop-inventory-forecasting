<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('purchases', function (Blueprint $table) {
        $table->id();
        $table->foreignId('product_id')->constrained()->cascadeOnDelete();
        $table->integer('quantity');
        $table->decimal('buy_price', 10, 2);
        $table->decimal('total_cost', 10, 2);
        $table->foreignId('purchased_by')->constrained('users');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
