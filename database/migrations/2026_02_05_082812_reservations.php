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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('vehicle_id')->constrained('vehicle');
            $table->foreignId('slot_id')->constrained('parking_slots');
            $table->boolean('is_free')->default(false);
            $table->decimal('total_amount', 8, 2)->default(0);
            $table->decimal('free_hours', 5, 2)->default(0);
            $table->decimal('paid_hours', 5, 2)->default(0);
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('status', ['pending','active', 'completed', 'cancelled'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('reservation');
    }
};
