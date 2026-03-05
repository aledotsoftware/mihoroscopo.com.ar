<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use App\Models\Subscription;
use App\Models\ExtradataHoroscope;
use App\Models\ContentAstralGuide;
use App\Models\ContentDailyAstroAdvice;
use App\Models\ContentHoroscope;
use App\Models\ContentLovePrediction;
use App\Models\ContentLoveRitual;
use App\Models\ContentLunarRitual;
use App\Models\ContentProsperityRitual;
use App\Models\ContentZodiacCompatibility;
use App\Models\EmailLog;
use Carbon\Carbon;

class SendDailyContentEmailsTest extends TestCase
{
    // use RefreshDatabase; // Use manual schema creation as per memory

    protected function setUp(): void
    {
        parent::setUp();

        // Mock public path for logs if needed, but default is fine.
        if (!file_exists(public_path('logs'))) {
            mkdir(public_path('logs'), 0755, true);
        }

        // Create tables
        Schema::create('subscriptions', function ($table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('status')->nullable();
            $table->string('external_reference')->nullable();
            $table->string('payment_type')->nullable();
            $table->integer('service_id')->default(1);
            $table->timestamps();
        });

        Schema::create('extradata_horoscopes', function ($table) {
            $table->id();
            $table->integer('subscription_id');
            $table->index('subscription_id');
            $table->string('signo')->nullable();
            $table->string('name')->nullable();
        });

        Schema::create('email_logs', function ($table) {
            $table->id();
            $table->integer('subscription_id');
            $table->index('subscription_id');
            $table->string('service_type')->nullable();
            $table->string('content_id')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });

        // Content tables
        $contentTables = [
            'content_astral_guide',
            'content_daily_astro_advice',
            'content_horoscopes',
            'content_love_prediction',
            'content_love_ritual',
            'content_lunar_ritual',
            'content_prosperity_ritual',
            'content_zodiac_compatibility'
        ];

        foreach ($contentTables as $tableName) {
            Schema::create($tableName, function ($table) {
                $table->id();
                $table->date('date');
                $table->string('zodiac_sign');
                $table->text('content');
                $table->timestamps();
            });
        }
    }

    public function test_command_sends_emails_and_queries_count()
    {
        Mail::fake();

        // Seed Users
        $subscription1 = Subscription::create([
            'email' => 'user1@example.com',
            'status' => 'authorized',
            'external_reference' => 'ref1',
            'payment_type' => 'cc',
            'service_id' => 1
        ]);

        ExtradataHoroscope::create([
            'subscription_id' => $subscription1->id,
            'signo' => 'aries',
            'name' => 'User One'
        ]);

        $subscription2 = Subscription::create([
            'email' => 'user2@example.com',
            'status' => 'authorized',
            'external_reference' => 'ref2',
            'payment_type' => 'cc',
            'service_id' => 1
        ]);

        ExtradataHoroscope::create([
            'subscription_id' => $subscription2->id,
            'signo' => 'taurus',
            'name' => 'User Two'
        ]);

        // Seed Content for Today
        $date = Carbon::now()->format('Y-m-d');
        $signs = ['aries', 'taurus', 'gemini', 'cancer', 'leo', 'virgo', 'libra', 'scorpio', 'sagittarius', 'capricorn', 'aquarius', 'pisces'];

        $models = [
            ContentAstralGuide::class,
            ContentDailyAstroAdvice::class,
            ContentHoroscope::class,
            ContentLovePrediction::class,
            ContentLoveRitual::class,
            ContentLunarRitual::class,
            ContentProsperityRitual::class,
            ContentZodiacCompatibility::class,
        ];

        foreach ($models as $model) {
            foreach ($signs as $sign) {
                $model::create([
                    'date' => $date,
                    'zodiac_sign' => $sign,
                    'content' => "Content for $sign in " . class_basename($model)
                ]);
            }
        }

        DB::enableQueryLog();

        // Run command
        $this->artisan('send:daily-content-emails')
             ->assertExitCode(0);

        $queries = DB::getQueryLog();
        $queryCount = count($queries);

        // Analyze queries
        // Optimized behavior:
        // 1 query to count subscriptions
        // 1 query to fetch subscriptions (chunk) + 1 for eager loaded extradata
        // 8 queries for Content tables (once)
        // 2 queries for EmailLog create (one per user)
        // Total ~ 1 + 2 + 8 + 2 = 13 queries.

        // Assert significant reduction (Original was ~21 queries for 2 users)
        $this->assertLessThan(15, $queryCount, "Expected queries to be optimized (less than 15, was $queryCount)");

        // Assert email sent
        Mail::assertSent(\App\Mail\DailyContentEmail::class, 2);
    }
}
