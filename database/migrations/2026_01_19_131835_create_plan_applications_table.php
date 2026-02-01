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
        Schema::create('plan_applications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained()->cascadeOnDelete();

            $table->string('shop_name');
            $table->string('applicant_name');
            $table->string('applicant_email');
            $table->string('applicant_phone')->nullable();
            $table->text('message')->nullable();

            $table->enum('billing_cycle', ['monthly', 'yearly']);
            $table->integer('duration_months');

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_applications');
    }
};
