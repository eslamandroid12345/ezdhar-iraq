<?php

namespace App\Console;

use App\Console\Commands\AddWalletProvider;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [AddWalletProvider::class];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('wallet:add')->daily();
    }


    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
