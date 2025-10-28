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
        Schema::table('email_logs', function (Blueprint $table) {
            $table->foreign(['subscription_id'], 'email_logs_ibfk_1')->references(['id'])->on('subscriptions')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['content_id'], 'email_logs_ibfk_2')->references(['id'])->on('content_horoscopes')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('email_logs', function (Blueprint $table) {
            $table->dropForeign('email_logs_ibfk_1');
            $table->dropForeign('email_logs_ibfk_2');
        });
    }
};
