<?php

namespace App\Kernel\Parser\Classes;

use Exception;
use App\Models\Driver;
use App\Kernel\Parser\Exceptions\NotFoundDriverException;

class Creator {

    protected DriverAbstract $driver ;

    public function links(){
        Driver::all()->each(function($driver){

            $driverClass = $driver->driver_class ;

            if( !class_exists($driverClass) )
                throw new NotFoundDriverException() ;

            $this->driver = new $driverClass ;
            $this->driver->links() ;

        });
    }

}
