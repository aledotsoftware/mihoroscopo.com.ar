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
        Schema::table('field_definitions', function (Blueprint $table) {
            $table->foreign(['service_id'], 'field_definitions_ibfk_1')->references(['id'])->on('services')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('field_definitions', function (Blueprint $table) {
            $table->dropForeign('field_definitions_ibfk_1');
        });
    }
};
