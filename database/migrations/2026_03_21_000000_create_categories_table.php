<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('categories');
    }

    public function down(): void
    {
        Schema::create('categories', function ($table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });
    }
};