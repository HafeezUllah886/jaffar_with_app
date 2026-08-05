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
        Schema::create('deep_freezers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('type');
            $table->string('size');
            $table->string('status');
            $table->timestamps();
        });

        Schema::create('deep_freezer_scans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deep_freezer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamp('scan_time');
            $table->string('lat');
            $table->string('long');
            $table->foreignId('customer_id')->nullable()->constrained('accounts')->cascadeOnDelete();
            $table->string('customer_lat')->nullable();
            $table->string('customer_long')->nullable();
            $table->bigInteger('distance')->nullable();
            $table->timestamps();
        });

        Schema::create('deep_freezer_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('accounts')->cascadeOnDelete();
            $table->foreignId('deep_freezer_id')->constrained()->cascadeOnDelete();
            $table->string('vehicleNo')->nullable();
            $table->string('driver')->nullable();
            $table->string('doc_no')->nullable();
            $table->date('date');
            $table->string('type');
            $table->string('reason')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deep_freezer_movements');
        Schema::dropIfExists('deep_freezer_scans');
        Schema::dropIfExists('deep_freezers');
    }
};
