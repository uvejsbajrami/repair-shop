<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE repair_logs MODIFY COLUMN old_status ENUM('pending', 'working', 'finished', 'pickedup') NOT NULL");
        DB::statement("ALTER TABLE repair_logs MODIFY COLUMN new_status ENUM('pending', 'working', 'finished', 'pickedup') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE repair_logs MODIFY COLUMN old_status ENUM('pending', 'working', 'finished') NOT NULL");
        DB::statement("ALTER TABLE repair_logs MODIFY COLUMN new_status ENUM('pending', 'working', 'finished') NOT NULL");
    }
};
