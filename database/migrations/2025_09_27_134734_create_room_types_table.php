<?php

use App\Enums\RoomTypeStatus;
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
        Schema::create('room_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('view')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('size');
            $table->unsignedInteger('max_adult');
            $table->unsignedInteger('max_children');
            $table->unsignedInteger('max_total_guests');
            $table->decimal('price', 8, 2);
            $table->decimal('extra_bed_price', 8, 2);
            $table->enum('status', RoomTypeStatus::cases());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_types');
    }
};
