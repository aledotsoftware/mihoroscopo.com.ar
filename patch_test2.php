<?php
$content = file_get_contents('tests/Feature/SendDailyContentEmailsTest.php');

$search = <<<'SEARCH'
        Schema::create('subscriptions', function ($table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('status')->nullable();
            $table->string('external_reference')->nullable();
            $table->string('payment_type')->nullable();
            $table->integer('service_id')->default(1);
            $table->timestamps();
        });
SEARCH;

$replace = <<<'REPLACE'
        Schema::create('subscriptions', function ($table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('status')->nullable();
            $table->string('external_reference')->nullable();
            $table->string('payment_type')->nullable();
            $table->integer('service_id')->default(1);
            $table->string('subscription_id')->nullable();
            $table->timestamps();

            // ⚡ Bolt: Indexes to match migration
            $table->index('email');
            $table->index('external_reference');
            $table->index('subscription_id');
        });
REPLACE;

$content = str_replace($search, $replace, $content);

file_put_contents('tests/Feature/SendDailyContentEmailsTest.php', $content);
echo "Patched SendDailyContentEmailsTest\n";
