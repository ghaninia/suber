<?php

namespace App\Kernel\UploadCenter;

use App\Kernel\UploadCenter\Abstracts\UploadCenterAbstract;

class PostFile extends UploadCenterAbstract
{

    public function __construct(protected int $productionYear ,protected string $name){
        parent::__construct() ;
    }

    public function servicePathName(): string|array
    {
        return [
            $this->productionYear ,
            $this->name
        ] ;
    }

}
