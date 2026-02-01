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
        Schema::create('shop_settings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('shop_id')->constrained()->cascadeOnDelete();

            $table->string('logo_path')->nullable();
            $table->string('primary_color')->default('#2563eb');
            $table->string('accent_color')->default('#22c55e');

            $table->string('currency_code')->default('EUR');
            $table->string('currency_symbol')->default('€');

            $table->boolean('remove_branding')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_settings');
    }
};
