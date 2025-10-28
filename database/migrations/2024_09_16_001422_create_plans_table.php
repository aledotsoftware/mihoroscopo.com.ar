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
        Schema::create('plans', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('service')->index('service');
            $table->string('name');
            $table->integer('frequency');
            $table->enum('frequency_type', ['days', 'weeks', 'months']);
            $table->decimal('transaction_amount', 10);
            $table->string('currency_id', 3);
            $table->integer('free_trial')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
