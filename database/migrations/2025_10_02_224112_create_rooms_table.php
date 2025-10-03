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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->integer('room_number')->unique();
            $table->foreignId('room_type_id')->constrained();
            $table->integer('floor_number');
            $table->enum('status', ['available', 'occupied', 'maintenance'])->default('available');
            $table->enum('smoking_preference', ['no_preference','non_smoking','smoking'])->default('no_preference');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
