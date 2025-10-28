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
        Schema::table('field_values', function (Blueprint $table) {
            $table->foreign(['field_definition_id'], 'field_values_ibfk_1')->references(['id'])->on('field_definitions')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('field_values', function (Blueprint $table) {
            $table->dropForeign('field_values_ibfk_1');
        });
    }
};
