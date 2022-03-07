<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Link extends Model
{

    use HasFactory;

    protected $fillable = [
        "driver_id",
        "url",





        
    ];

    protected $casts = [
        "is_visited" => "boolean",
        "visited_date" => "datetime",
    ];

    public $dates = [
        "visited_date",
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function post()
    {
        return $this->hasOne(Post::class);
    }
}
