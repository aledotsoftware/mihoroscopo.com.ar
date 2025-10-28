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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email')->nullable();
            $table->integer('service_id')->index('fk_service_id');
            $table->string('subscription_id');
            $table->string('status')->default('pending');
            $table->string('external_reference', 23);
            $table->string('payment_type')->nullable();
            $table->text('response')->nullable();
            $table->integer('charged_quantity')->nullable();
            $table->decimal('charged_amount', 10)->nullable();
        
            $table->decimal('pending_charge_amount', 10)->nullable();
            $table->string('semaphore')->nullable();
            $table->timestamp('last_charged_date')->nullable();
            $table->decimal('last_charged_amount', 10)->nullable();
            $table->timestamp('next_payment_date')->nullable();
            $table->string('payment_method_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
