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
        Schema::create('payment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('external_reference');
            $table->text('payment_id');
            $table->text('preapproval_id');
            $table->decimal('net_received_amount', 15);
            $table->decimal('total_paid_amount', 15);
            $table->string('status')->default('pending');
            $table->enum('currency_id', ['ARS']);
            $table->text('payer_email');
            $table->text('payer_identification_number');
            $table->text('payer_identification_type');
            $table->text('payer_first_name')->nullable();
            $table->text('payer_last_name')->nullable();
            $table->text('payment_method_id');
            $table->longText('payload')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment');
    }
};
