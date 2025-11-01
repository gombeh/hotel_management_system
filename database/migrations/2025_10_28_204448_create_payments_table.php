<?php

use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained();
            $table->decimal('amount', 8, 2)->default(0);
            $table->enum('type', PaymentType::cases());
            $table->enum('payment_method', PaymentType::cases());
            $table->enum('status', PaymentStatus::cases())->default(PaymentType::default());
            $table->string('reference')->nullable();
            $table->text('note')->nullable();
            $table->timestamps('paid_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
