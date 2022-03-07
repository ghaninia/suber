<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Kernel\UploadCenter\Interfaces\FileInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class File extends Model implements FileInterface
{
    use HasFactory;

    protected $fillable = [
        "disk",
        "fileable_id",
        "fileable_type",
        "name",
        "path",
    ];

    ###################
    #### RELATIONS ####
    ###################

    public function fileable()
    {
        return $this->morphTo();
    }

}
