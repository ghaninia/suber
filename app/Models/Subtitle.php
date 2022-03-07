<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Kernel\UploadCenter\Traits\HasFileableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Kernel\UploadCenter\Interfaces\FileableInterface;

class Subtitle extends Model implements FileableInterface
{

    use HasFactory, HasFileableTrait;

    protected $fillable = [
        "language",
        "post_id",
        "film_resulation"
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

}
