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
        $tables = [
            'content_astral_guide',
            'content_daily_astro_advice',
            'content_horoscopes',
            'content_love_prediction',
            'content_love_ritual',
            'content_lunar_ritual',
            'content_prosperity_ritual',
            'content_zodiac_compatibility'
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                // ⚡ Bolt: Database index optimization.
                // What: Added an index on the 'date' column.
                // Why: The SendDailyContentEmails command queries these tables daily using the 'date' column. Without an index, it performs a full table scan on every execution.
                // Impact: Changes a full table scan O(N) into an indexed lookup O(log N).
                $table->index('date');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'content_astral_guide',
            'content_daily_astro_advice',
            'content_horoscopes',
            'content_love_prediction',
            'content_love_ritual',
            'content_lunar_ritual',
            'content_prosperity_ritual',
            'content_zodiac_compatibility'
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropIndex(['date']);
            });
        }
    }
};
