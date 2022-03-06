<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model {

    use HasFactory;

    protected $fillable = [
        "driver_id" ,
        "url" ,
        "is_visited" ,
        "visited_date" ,
    ];

    protected $casts = [
        "is_visited" => "boolean" ,
        "visited_date" => "datetime" ,
    ];

    public $dates = [
        "visited_date" ,
    ];

    public function driver(){
        return $this->belongsTo(Driver::class) ;
    }

}
