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
        // Use raw SQL to alter column type to char(36) so UUIDs fit.
        // This avoids requiring doctrine/dbal for the ->change() method.
        DB::statement("ALTER TABLE personal_access_tokens MODIFY COLUMN tokenable_id CHAR(36) NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // revert to unsigned big integer (original Sanctum migration)
        DB::statement("ALTER TABLE personal_access_tokens MODIFY COLUMN tokenable_id BIGINT UNSIGNED NOT NULL");
    }
};
