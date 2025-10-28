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
        Schema::create('extra_fields', function (Blueprint $table) {
            $table->integer('id', true);
            $table->unsignedBigInteger('subscription_id')->index('fk_subscription_id');
            $table->integer('service_id')->index('fk_service_id');
            $table->integer('field_definition_id')->index('fk_field_definition_id');
            $table->string('field_value')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extra_fields');
    }
};
