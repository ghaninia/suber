<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Kernel\UploadCenter\Traits\HasFileableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Kernel\UploadCenter\Interfaces\FileableInterface;

class Post extends Model implements FileableInterface
{
    use HasFactory, HasFileableTrait;

    protected $fillable = [
        "name",
        "production_year",
        "imdb",
    ];

    public function link()
    {
        return $this->hasOne(Link::class);
    }

    public function subtitles()
    {
        return $this->hasMany(Subtitle::class);
    }
}
