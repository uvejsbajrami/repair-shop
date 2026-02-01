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
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('shop_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained()->cascadeOnDelete();
            $table->string('paypal_order_id')->nullable();
            $table->string('paypal_payer_id')->nullable();
            $table->integer('amount'); // Amount in cents
            $table->string('currency', 3)->default('EUR');
            $table->integer('duration_months');
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');
            $table->enum('payment_method', ['paypal', 'card'])->nullable();
            $table->timestamps();

            $table->index('paypal_order_id');
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
