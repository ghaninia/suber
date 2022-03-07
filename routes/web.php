<?php

use App\Kernel\Parser\Classes\Creator;
use App\Kernel\Parser\Drivers\WorldSubtitle\WorldSubtitle;
use App\Kernel\Parser\Exceptions\NotFoundDriverException;
use App\Models\Driver;
use App\Models\Link;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    (new Creator)->links();
});
