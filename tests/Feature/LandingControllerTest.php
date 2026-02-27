<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class LandingControllerTest extends TestCase
{
    public function test_landing_page_caches_geoip_lookup()
    {
        // Mock Cache::remember call
        Cache::shouldReceive('remember')
            ->once()
            ->withArgs(function ($key, $ttl, $callback) {
                return str_starts_with($key, 'geoip_country_') && $ttl == 86400;
            })
            ->andReturn('US');

        $response = $this->get('/landing');

        $response->assertStatus(200);
        $response->assertViewHas('country', 'US');
    }
}
