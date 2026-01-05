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
     Schema::create('restaurants', function (Blueprint $table) {
    $table->id();
    $table->foreignId('cuisine_id')->constrained()->cascadeOnDelete();

    $table->string('name');
    $table->string('slug')->unique();

    $table->string('address');
    $table->decimal('lat', 10, 7)->nullable();
    $table->decimal('lng', 10, 7)->nullable();

    $table->decimal('rating', 2, 1)->default(0.0);
    $table->text('description')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};
