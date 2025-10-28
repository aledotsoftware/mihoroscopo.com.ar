<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateConversions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-ads-conversions';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ejecuta el stored procedure GenerateConversions';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Ejecuta el stored procedure
        DB::statement('CALL GenerateConversions()');
        DB::statement('CALL GenerateConversionsOnlyPayments()');
        $this->info('Stored procedure GenerateConversions ejecutado correctamente.');

        return 0;
    }
}
