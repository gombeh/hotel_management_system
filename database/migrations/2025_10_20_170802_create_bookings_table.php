<?php

use App\Enums\BookingStatus;
use App\Enums\SmokingPreference;
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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('ref_number')->unique();
            $table->foreignId('customer_id')->constrained();
            $table->unsignedInteger('adults');
            $table->unsignedInteger('children')->default(0);
            $table->text('special_requests')->nullable();
            $table->enum('smoking_preference', SmokingPreference::cases());
            $table->date('check_in');
            $table->date('check_out');
            $table->enum('status', BookingStatus::cases())->default(BookingStatus::default());
            $table->timestamp('lock_until_at')->nullable();
            $table->foreignId('meal_plan_id')->nullable()->constrained();
            $table->decimal('total_price', 8, 2)->default(0);
            $table->decimal('partial_amount', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
