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
        Schema::create('extradata_horoscopes', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('subscription_id');
            $table->string('name')->nullable();
            $table->string('signo');
            $table->string('gclid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extradata_horoscopes');
    }
};
