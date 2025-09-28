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
        Schema::create('room_type_facility', function (Blueprint $table) {
            $table->foreignId('room_type_id')->constrained();
            $table->foreignId('facility_id')->constrained();
            $table->primary(['room_type_id', 'facility_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_type_facility');
    }
};
