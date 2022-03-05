<?php

namespace App\Kernel\Parser\Drivers\WorldSubtitle ;

use App\Kernel\Parser\Classes\DriverAbstract;
use Illuminate\Support\Facades\Http;

class WordSubtitle extends DriverAbstract {

    public function getTheLatestPages() : int
    {
        $http = Http::get($this->driver->url) ;
    }

}
