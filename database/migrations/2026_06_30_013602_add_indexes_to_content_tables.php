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
        // ⚡ Bolt: Database index optimization.
        // What: Added indexes on date column for content tables.
        // Why: The date column is frequently used in WHERE clauses in SendDailyContentEmails command, causing
        //      full table scans without indexes.
        // Impact: Significantly reduces database query times and CPU usage for daily content lookups.
        Schema::table('content_astral_guide', function (Blueprint $table) {
            $table->index('date');
        });
        Schema::table('content_daily_astro_advice', function (Blueprint $table) {
            $table->index('date');
        });
        Schema::table('content_horoscopes', function (Blueprint $table) {
            $table->index('date');
        });
        Schema::table('content_love_prediction', function (Blueprint $table) {
            $table->index('date');
        });
        Schema::table('content_love_ritual', function (Blueprint $table) {
            $table->index('date');
        });
        Schema::table('content_lunar_ritual', function (Blueprint $table) {
            $table->index('date');
        });
        Schema::table('content_prosperity_ritual', function (Blueprint $table) {
            $table->index('date');
        });
        Schema::table('content_zodiac_compatibility', function (Blueprint $table) {
            $table->index('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('content_astral_guide', function (Blueprint $table) {
            $table->dropIndex(['date']);
        });
        Schema::table('content_daily_astro_advice', function (Blueprint $table) {
            $table->dropIndex(['date']);
        });
        Schema::table('content_horoscopes', function (Blueprint $table) {
            $table->dropIndex(['date']);
        });
        Schema::table('content_love_prediction', function (Blueprint $table) {
            $table->dropIndex(['date']);
        });
        Schema::table('content_love_ritual', function (Blueprint $table) {
            $table->dropIndex(['date']);
        });
        Schema::table('content_lunar_ritual', function (Blueprint $table) {
            $table->dropIndex(['date']);
        });
        Schema::table('content_prosperity_ritual', function (Blueprint $table) {
            $table->dropIndex(['date']);
        });
        Schema::table('content_zodiac_compatibility', function (Blueprint $table) {
            $table->dropIndex(['date']);
        });
    }
};
