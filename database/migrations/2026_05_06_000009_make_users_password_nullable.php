<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE users ALTER COLUMN password_hash DROP NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("UPDATE users SET password_hash = '' WHERE password_hash IS NULL");
        DB::statement("ALTER TABLE users ALTER COLUMN password_hash SET NOT NULL");
    }
};
