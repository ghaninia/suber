<?php

namespace App\Kernel\UploadCenter\Drivers;

use App\Kernel\Enums\EnumFile;
use App\Kernel\UploadCenter\Interfaces\UploadDriverInterface;

class S3Driver implements UploadDriverInterface
{
    public function disk(): string
    {
        return EnumFile::DRIVER_S3;
    }
}
