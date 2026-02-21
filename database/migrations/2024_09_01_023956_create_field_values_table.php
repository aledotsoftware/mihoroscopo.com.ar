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
        Schema::create('field_values', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('field_definition_id')->index();
            $table->string('value');

            $table->unique(['field_definition_id', 'value'], 'unique_field_value');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('field_values');
    }
};
