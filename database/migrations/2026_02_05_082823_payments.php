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
        Schema::create('payments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('reservation_id')->nullable()->constrained('reservations');
        $table->string('paymongo_reference')->nullable();
        $table->decimal('amount', 8, 2);
        $table->enum('payment_method', ['gcash', 'maya', 'card', 'cash'])->default('gcash');
        $table->enum('payment_status', ['unpaid', 'processing', 'paid', 'failed', 'refunded'])->default('unpaid');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('payments');
    }
};
