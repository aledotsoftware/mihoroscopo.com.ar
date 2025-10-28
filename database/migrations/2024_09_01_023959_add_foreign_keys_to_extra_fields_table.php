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
        Schema::table('extra_fields', function (Blueprint $table) {
            $table->foreign(['subscription_id'], 'extra_fields_ibfk_1')->references(['id'])->on('subscriptions')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['service_id'], 'extra_fields_ibfk_2')->references(['id'])->on('services')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['field_definition_id'], 'extra_fields_ibfk_3')->references(['id'])->on('field_definitions')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['field_value_id'], 'extra_fields_ibfk_4')->references(['id'])->on('field_values')->onUpdate('restrict')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('extra_fields', function (Blueprint $table) {
            $table->dropForeign('extra_fields_ibfk_1');
            $table->dropForeign('extra_fields_ibfk_2');
            $table->dropForeign('extra_fields_ibfk_3');
            $table->dropForeign('extra_fields_ibfk_4');
        });
    }
};
