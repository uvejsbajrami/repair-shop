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
        Schema::create('repairs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('shop_id')->constrained()->cascadeOnDelete();
            $table->foreignId('assigned_employee_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('device_type');

            $table->text('issue_description');
            $table->text('notes')->nullable();

            $table->enum('status', ['pending', 'working', 'finished'])->default('pending');

            $table->string('tracking_code')->unique();
            $table->integer('price_amount')->nullable();
            $table->integer('position')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repairs');
    }
};
