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
            $table->foreignId('shop_id')->nullable()->after('plan_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['new', 'renewal'])->default('new')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plan_applications', function (Blueprint $table) {
            $table->dropForeign(['shop_id']);
            $table->dropColumn(['shop_id', 'type']);
        });
    }
};
