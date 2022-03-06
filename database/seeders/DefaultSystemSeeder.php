<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Driver;
use Illuminate\Database\Seeder;
use App\Kernel\Parser\Drivers\WorldSubtitle\WorldSubtitle;

class DefaultSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Driver::insert([
            [
                "name" => "زیرنویس فیلم های سایت worldSubtitle" ,
                "driver_class" => WorldSubtitle::class ,
                "base_uri_host" => "https://worldsubtitle.site/category/movies/" ,
                "next_page_link" => "/" ,
                "created_at"   => Carbon::now() ,
            ]
        ]);
    }
}
