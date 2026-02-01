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
        Schema::table('shop_plans', function (Blueprint $table) {
            $table->timestamp('grace_email_sent_at')->nullable()->after('status');
            $table->timestamp('expired_email_sent_at')->nullable()->after('grace_email_sent_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shop_plans', function (Blueprint $table) {
            $table->dropColumn(['grace_email_sent_at', 'expired_email_sent_at']);
        });
    }
};
