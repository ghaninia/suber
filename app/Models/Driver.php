<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Kernel\Parser\Interfaces\DriverModelInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Driver extends Model implements DriverModelInterface
{
    use HasFactory;

    protected $fillable = [
        "name",
        "attacks_count",
        "latest_count_pages",
        "current_attack_page",

        "start_page_link",
        "previous_page_link",
        "next_page_link",
    ];

    protected $guard = [
        "base_uri_host",
        "driver_class",
    ];

    public function links(): HasMany
    {
        return $this->hasMany(Link::class);
    }
}
