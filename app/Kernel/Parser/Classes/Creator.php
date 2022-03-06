<?php

namespace App\Kernel\Parser\Classes;

use App\Models\Driver;
use App\Kernel\Parser\Exceptions\NotFoundDriverException;

class Creator
{
    private function driver(callable $callbak) {
        Driver::all()->each(function ($driver) use ( $callbak ) {

            // dispatch(function () use ($driver , $callbak) {

                $driverClass = $driver->driver_class;

                if (!class_exists($driverClass))
                    throw new NotFoundDriverException();

                $driver = new $driverClass($driver);

                return $callbak($driver) ;

            // });

        });
    }

    public function link()
    {
        $this->driver(function($driver){
            $driver->links();
        });
    }

    public function paginations()
    {
        $this->driver(function($driver){
            $driver->reloadPaginator();
        });
    }
}
