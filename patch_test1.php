<?php
$content = file_get_contents('tests/Feature/SubscriptionTest.php');

$search = <<<'SEARCH'
        \Illuminate\Support\Facades\Schema::create('subscriptions', function ($table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('external_reference')->nullable();
            $table->string('subscription_id')->nullable();
            $table->string('status')->nullable();
            $table->string('currency')->nullable();
            $table->string('country')->nullable();
            $table->integer('service_id')->default(1);
            $table->integer('payment_provider_id')->default(1);
            $table->timestamps();
        });
SEARCH;

$replace = <<<'REPLACE'
        \Illuminate\Support\Facades\Schema::create('subscriptions', function ($table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('external_reference')->nullable();
            $table->string('subscription_id')->nullable();
            $table->string('status')->nullable();
            $table->string('currency')->nullable();
            $table->string('country')->nullable();
            $table->integer('service_id')->default(1);
            $table->integer('payment_provider_id')->default(1);
            $table->timestamps();

            // ⚡ Bolt: Indexes to match migration
            $table->index('email');
            $table->index('external_reference');
            $table->index('subscription_id');
        });
REPLACE;

$content = str_replace($search, $replace, $content);

file_put_contents('tests/Feature/SubscriptionTest.php', $content);
echo "Patched SubscriptionTest\n";
