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
                // Why: The 'date' column is heavily queried in the 'SendDailyContentEmails' command
                //      where it fetches content for millions of subscribers daily. Without an index,
                //      the database performs full table scans for each content type.
                // Impact: Significantly reduces database CPU load and speeds up query execution time during daily batch processing.
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
