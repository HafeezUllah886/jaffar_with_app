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
        Schema::create('self_target_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('targetID')->constrained('self_targets', 'id');
            $table->foreignId('categoryID')->constrained('categories', 'id');
            $table->float('qty');
            $table->foreignId('unitID')->constrained('units', 'id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('self_target_details');
    }
};
