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

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'date')) {
                Schema::table($table, function (Blueprint $blueprint) use ($table) {
                    $blueprint->index('date', $table . '_date_index');
                });
            }
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

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'date')) {
                Schema::table($table, function (Blueprint $blueprint) use ($table) {
                    $blueprint->dropIndex($table . '_date_index');
                });
            }
        }
    }
};
