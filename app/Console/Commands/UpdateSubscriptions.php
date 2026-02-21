<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subscription;
use App\Services\MercadoPagoService;
use App\Services\DlocalGoService;
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
    protected $description = 'Update subscription status by checking with MercadoPago or dLocalGo';

    protected $mercadoPagoService;
    protected $dlocalGoService;
    protected $discordService;

    public function __construct(MercadoPagoService $mercadoPagoService, DlocalGoService $dlocalGoService)
    {
        parent::__construct();
        $this->mercadoPagoService = $mercadoPagoService;
        $this->dlocalGoService = $dlocalGoService;
        $this->discordService = new DiscordService(1);
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $subscriptions = Subscription::where('payment_type', '!=', 'gaia')
            ->get();

        foreach ($subscriptions as $subscription) {
            try {
                // Determine provider: 1 = MercadoPago, otherwise dLocalGo (usually 2)
                // Also check currency as a fallback if payment_provider_id is null
                $isMercadoPago = ($subscription->payment_provider_id == 1) || ($subscription->currency === 'ARS');

                if ($isMercadoPago) {
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
                } else {
                    // dLocalGo
                    $dlocalSubscription = $this->dlocalGoService->getSubscription($subscription->subscription_id);

                    // Map dLocal status to internal status
                    $dlocalStatus = strtoupper($dlocalSubscription['status'] ?? '');
                    $status = 'pending';

                    if ($dlocalStatus === 'ACTIVE') {
                        $status = 'authorized';
                    } elseif ($dlocalStatus === 'CANCELLED') {
                        $status = 'cancelled';
                    } elseif ($dlocalStatus === 'PAUSED') {
                        $status = 'paused';
                    } else {
                        $status = $subscription->status; // Keep current status if unknown
                    }

                    $subscription->fill([
                        'status' => $status,
                        'updated_at' => now(),
                    ]);

                    // Update other fields if available in response
                    if (isset($dlocalSubscription['next_execution_date'])) {
                        $subscription->next_payment_date = $dlocalSubscription['next_execution_date'];
                    }
                }

                $subscription->save();
            } catch (\Exception $e) {
                $this->discordService->sendDiscordMessage("Error updating subscription {$subscription->subscription_id}: {$e->getMessage()}");
            }
        }

        $this->info('Subscriptions updated successfully.');
        $this->discordService->sendDiscordMessage('Subscriptions updated successfully.');
    }
}
