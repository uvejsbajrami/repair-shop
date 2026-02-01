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
        Schema::table('plan_applications', function (Blueprint $table) {
            $table->string('payment_proof_path')->nullable()->after('type');
            $table->enum('payment_status', ['awaiting_proof', 'proof_submitted', 'payment_verified', 'payment_rejected'])
                ->default('awaiting_proof')
                ->after('payment_proof_path');
            $table->timestamp('payment_proof_uploaded_at')->nullable()->after('payment_status');
            $table->text('payment_notes')->nullable()->after('payment_proof_uploaded_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plan_applications', function (Blueprint $table) {
            $table->dropColumn([
                'payment_proof_path',
                'payment_status',
                'payment_proof_uploaded_at',
                'payment_notes',
            ]);
        });
    }
};
