<?php

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Register The Composer Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader
| for our application. We just need to utilize it! We'll require it
| into the script here so that we do not have to worry about the
| loading of any our classes "manually". Feels great to relax.
|
*/

require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Include The Compiled Class File
|--------------------------------------------------------------------------
|
| To dramatically increase your application's performance, you may use a
| compiled class file which contains all of the classes commonly used
| by a request. The Artisan "optimize" is used to create this file.
|
*/

$compiledPath = __DIR__.'/cache/compiled.php';

require 'scorecard_core_function.php';
require 'AppCalculation.php';
require 'Api/order_api_core_function.php';
require 'Api/api_core_function.php';
require 'Api/Neptune_api_core_function.php';
require 'Api/app_calculation_core.php';
require 'APPcalulation/app_base_function.php';
require 'neptuneglobal.php';

if (file_exists($compiledPath)) {
    require $compiledPath;
}
//
define('Current_month',date('m'));
define('Current_Year',date('Y'));
//define('Current_month','03');
//define('Current_Year','2018');
define('Current_date',\Carbon\Carbon::now()->format("Y-m-d"));
//define('Current_date','2017-08-01');
define('color1','#FF0800');
define('color2','#CC5500');
define('color3','#073F84');
define('day1',30);
define('day2',60);
define('day3',61);


