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
            $table->string('applicant_name')->after('shop_name');
            $table->string('applicant_email')->after('applicant_name');
            $table->string('applicant_phone')->nullable()->after('applicant_email');
            $table->text('message')->nullable()->after('duration_months');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plan_applications', function (Blueprint $table) {
            $table->dropColumn(['applicant_name', 'applicant_email', 'applicant_phone', 'message']);
        });
    }
};
