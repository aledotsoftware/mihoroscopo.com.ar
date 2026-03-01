<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subscription;
use App\Services\MercadoPagoService;
use App\Services\DiscordService;

class UpdateSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-subscriptions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update subscription status by checking with MercadoPago';

    protected $mercadoPagoService;
    protected $discordService;

    public function __construct(MercadoPagoService $mercadoPagoService)
    {

        parent::__construct();
        $this->mercadoPagoService = $mercadoPagoService;
        $this->discordService = new DiscordService(1);
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // ⚡ Bolt: Memory optimization.
        // What: Replaced ->get() with ->chunkById() to process subscriptions in batches of 100.
        // Why: Loading all subscriptions into memory at once with get() causes massive memory overhead
        //      when the table is large, often leading to OOM (Out Of Memory) exceptions on the server.
        // Impact: Reduces memory usage exponentially from O(N) to O(1) where N is the number of records.
        Subscription::where('payment_type', '!=', 'gaia')
            ->chunkById(100, function ($subscriptions) {
                foreach ($subscriptions as $subscription) {
                    try {
                        $mercadoPagoSubscription = $this->mercadoPagoService->getSubscription($subscription->subscription_id);
                        $subscription->fill([
                            'status' => $mercadoPagoSubscription['status'] ?? 'gaia',
                            'next_payment_date' => $mercadoPagoSubscription['next_payment_date'] ?? null,
                            'payment_method_id' => $mercadoPagoSubscription['payment_method_id'] ?? null,
                            'charged_quantity' => $mercadoPagoSubscription['summarized']['charged_quantity'] ?? null,
                            'charged_amount' => $mercadoPagoSubscription['summarized']['charged_amount'] ?? null,

                            'pending_charge_amount' => $mercadoPagoSubscription['summarized']['pending_charge_amount'] ?? null,
                            'semaphore' => $mercadoPagoSubscription['summarized']['semaphore'] ?? null,
                            'last_charged_date' => $mercadoPagoSubscription['summarized']['last_charged_date'] ?? null,
                            'last_charged_amount' => $mercadoPagoSubscription['summarized']['last_charged_amount'] ?? null,
                            'updated_at' => now(),
                        ]);

                        $subscription->save();
                    } catch (\Exception $e) {
                        $this->discordService->sendDiscordMessage("Error updating subscription {$subscription->subscription_id}: {$e->getMessage()}");
                    }
                }
            });

        $this->info('Subscriptions updated successfully.');
        $this->discordService->sendDiscordMessage('Subscriptions updated successfully.');
    }
}
