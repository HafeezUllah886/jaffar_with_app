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
        Schema::create('orderbooker_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('userID')->references('id')->on('users')->onDelete('cascade');
            $table->decimal('latitude', 10, 15);
            $table->decimal('longitude', 10, 15);
            $table->date('date')->default(now());
            $table->time('time')->default(now());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orderbooker_locations');
    }
};
