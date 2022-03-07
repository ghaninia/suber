<?php

namespace App\Listeners;

use App\Events\WhenLinkIsAdded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class FetchInformationFromTheSite implements ShouldQueue
{

    use InteractsWithQueue ;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\WhenLinkIsAdded  $event
     * @return void
     */
    public function handle(WhenLinkIsAdded $event)
    {
        $driver = ($link = $event->link)->driver ;
        $driverClass = $driver->driver_class ;

        (new $driverClass($driver))->fetch($link)->save() ;
    }
}
