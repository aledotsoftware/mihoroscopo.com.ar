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
        Schema::table('subscriptions', function (Blueprint $table) {
            // ⚡ Bolt: Database index optimization.
            // What: Added indexes on email, external_reference, and subscription_id.
            // Why: These columns are frequently used in WHERE clauses and relationships
            //      across the application (e.g., SubscriptionController, commands), causing
            //      full table scans without indexes.
            // Impact: Significantly reduces database query times and CPU usage for lookups.
            $table->index('email');
            $table->index('external_reference');
            $table->index('subscription_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropIndex(['email']);
            $table->dropIndex(['external_reference']);
            $table->dropIndex(['subscription_id']);
        });
    }
};
