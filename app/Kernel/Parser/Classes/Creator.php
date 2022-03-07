<?php

namespace App\Kernel\Parser\Classes;

use App\Models\Driver;
use App\Kernel\Parser\Exceptions\NotFoundDriverException;

class Creator
{

    /**
     * @param callable $callbak
     * @return void
     */
    private function driver(callable $callbak) {
        Driver::all()->each(function ($driver) use ( $callbak ) {

            dispatch(function () use ($driver , $callbak) {

                $driverClass = $driver->driver_class;

                if (!class_exists($driverClass))
                    throw new NotFoundDriverException();

                $driver = new $driverClass($driver);

                return $callbak($driver) ;

            });

        });
    }


    /**
     * @return void
     */
    public function links()
    {
        $this->driver(function($driver){
            $driver->links();
        });
    }

    /**
     * @return void
     */
    public function paginations()
    {
        $this->driver(function($driver){
            $driver->reloadPaginator();
        });
    }

}
