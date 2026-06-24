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
            'content_zodiac_compatibility',
        ];

        // ⚡ Bolt: Database performance optimization.
        // What: Added an index to the `date` column across all daily content tables.
        // Why: The application frequently queries these tables by `date` to generate daily content emails.
        //      Without an index, the database performs full table scans for every daily query, wasting CPU
        //      and increasing response time as the content tables grow.
        // Impact: Reduces the query time complexity from O(N) to O(log N), drastically speeding up the
        //      SendDailyContentEmails batch process.
        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
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
            'content_zodiac_compatibility',
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropIndex(['date']);
            });
        }
    }
};
