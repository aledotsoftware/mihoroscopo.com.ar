<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    // use RefreshDatabase; // Migrations are broken, creating tables manually

    protected function setUp(): void
    {
        parent::setUp();

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

        \Illuminate\Support\Facades\Schema::create('extradata_horoscopes', function ($table) {
            $table->id();
            $table->foreignId('subscription_id');
            $table->index('subscription_id');
            $table->string('signo')->nullable();
            $table->string('name')->nullable();
            $table->string('gclid')->nullable();
            $table->string('gbraid')->nullable();
            $table->string('wbraid')->nullable();
            $table->string('li_fat_id')->nullable();
            $table->string('li_ed')->nullable();
            $table->string('sub_days')->nullable();
            $table->string('cost')->nullable();
            $table->string('click_id')->nullable();
            $table->string('web_push_creative_id')->nullable();
            $table->string('mobile_brand')->nullable();
            $table->string('city_name')->nullable();
            $table->string('browser_family')->nullable();
            $table->string('os_type')->nullable();
            $table->string('price')->nullable();
            $table->string('region_name')->nullable();
            $table->string('spot_id')->nullable();
            $table->string('domain')->nullable();
            $table->timestamps();
        });
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_subscription_endpoint_works()
    {
        // Use UY to avoid MercadoPagoService call which logic differs for AR
        $response = $this->postJson('/api/v1/subscribe', [
            'email' => 'test@example.com',
            'zodiacSign' => 'aries',
            'name' => 'Test User',
            'country' => 'UY',
            'subscription' => 'paid',
        ]);

        $response->assertStatus(200);
    }

    public function test_rate_limiting()
    {
        // Limit is 60 per minute
        for ($i = 0; $i < 60; $i++) {
            $this->postJson('/api/v1/subscribe', [
                'email' => "test$i@example.com",
                'zodiacSign' => 'aries',
                'name' => 'Test User',
                'country' => 'UY',
                'subscription' => 'paid',
            ]);
        }

        $response = $this->postJson('/api/v1/subscribe', [
            'email' => 'limit@example.com',
            'zodiacSign' => 'aries',
            'name' => 'Test User',
            'country' => 'UY',
            'subscription' => 'paid',
        ]);

        $response->assertStatus(429);
    }
}
