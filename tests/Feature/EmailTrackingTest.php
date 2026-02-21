<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\URL;
use App\Models\EmailClick;

class EmailTrackingTest extends TestCase
{
    // use RefreshDatabase; // Skipping due to broken migrations

    protected function setUp(): void
    {
        parent::setUp();

        // Mock email_clicks table
        if (!\Illuminate\Support\Facades\Schema::hasTable('email_clicks')) {
            \Illuminate\Support\Facades\Schema::create('email_clicks', function ($table) {
                $table->id();
                $table->integer('email_log_id');
                $table->text('url');
                $table->timestamp('clicked_at')->useCurrent();
                $table->string('ip_address')->nullable();
                $table->string('user_agent')->nullable();
                $table->timestamps();
            });
        }
    }

    public function test_signed_tracking_link_redirects_and_logs()
    {
        $targetUrl = 'https://example.com';
        $emailLogId = 123;

        // Generate signed URL
        $url = URL::signedRoute('email.track.click', [
            'email' => $emailLogId,
            'url' => $targetUrl,
        ]);

        $response = $this->get($url);

        $response->assertRedirect($targetUrl);

        // Check DB
        $this->assertDatabaseHas('email_clicks', [
            'email_log_id' => $emailLogId,
            'url' => $targetUrl,
        ]);
    }

    public function test_unsigned_tracking_link_fails()
    {
        $targetUrl = 'https://example.com';
        $emailLogId = 123;

        $url = route('email.track.click', [
            'email' => $emailLogId,
            'url' => $targetUrl,
        ]);

        $response = $this->get($url);

        $response->assertStatus(403);
    }

    public function test_tampered_tracking_link_fails()
    {
         $targetUrl = 'https://example.com';
        $emailLogId = 123;

        // Generate signed URL
        $url = URL::signedRoute('email.track.click', [
            'email' => $emailLogId,
            'url' => $targetUrl,
        ]);

        // Tamper with URL (e.g. change email id)
        // Note: this simple replacement might break the signature structure if strictly checking, but it definitely invalidates signature
        $tamperedUrl = str_replace("email={$emailLogId}", "email=999", $url);

        $response = $this->get($tamperedUrl);

        $response->assertStatus(403);
    }
}
