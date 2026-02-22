<?php

namespace Tests\Feature;

use Tests\TestCase;

class LandingPageTest extends TestCase
{
    /**
     * Test that the landing page loads and contains the new UX attributes.
     */
    public function test_landing_page_loads_and_has_ux_attributes(): void
    {
        $response = $this->get('/landing');

        $response->assertStatus(200);

        // Check for autocomplete attributes
        $response->assertSee('autocomplete="email"', false);
        $response->assertSee('autocomplete="name"', false);

        // Check for inputmode
        $response->assertSee('inputmode="email"', false);

        // Check for JS function
        $response->assertSee('handleEnterKey', false);
    }
}
