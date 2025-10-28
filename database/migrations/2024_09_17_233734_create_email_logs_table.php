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
        Schema::create('email_logs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->unsignedBigInteger('subscription_id')->index('subscription_id');
            $table->enum('service_type', ['horoscope', 'otro_servicio']);
            $table->integer('content_id')->index('content_id');
            $table->timestamp('sent_at')->nullable()->useCurrent();
            $table->dateTime('opened_at')->nullable();
            $table->enum('status', ['sent', 'failed']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_logs');
    }
};
