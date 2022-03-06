<?php

namespace App\Console;

use App\Kernel\Parser\Classes\Creator;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Artisan;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('queue:work --daemon')
            ->cron('* * * * *')
            ->withoutOverlapping();

        $schedule->call(function () {
            (new Creator)->paginations();
        })
        ->cron('* * * * *');

        $schedule
            ->call(function () {
                /**
                 * create links
                 */
                (new Creator)->link();
            })
            ->cron('* * * * *');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
