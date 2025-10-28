<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\SendDailyContentEmails::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('send:daily-content-emails')->daily();
        $schedule->command('send:daily-remarketing-emails')->daily();
        $schedule->command('app:update-subscriptions')->daily();
        $schedule->command('app:generate-ads-conversions')->daily();


    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
