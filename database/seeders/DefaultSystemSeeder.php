<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Driver;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Kernel\Parser\Drivers\WorldSubtitle\WorldSubtitle;
use App\Kernel\UploadCenter\Abstracts\UploadCenterAbstract;

class DefaultSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Storage::deleteDirectory( UploadCenterAbstract::BASE_PATH );

        Driver::insert([
            [
                "name" => "زیرنویس فیلم های سایت worldSubtitle",
                "driver_class" => WorldSubtitle::class,
                "base_uri_host" => "https://worldsubtitle.site",
                "start_page_link" => "category/movies",
                "next_page_link" => "category/movies",
                "created_at"   => Carbon::now(),
            ]
        ]);
    }
}
