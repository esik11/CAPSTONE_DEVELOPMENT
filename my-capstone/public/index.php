<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
|
| If the application is in maintenance / demo mode via the "down" command
| we will require this file so that any functions or classes are properly
| loaded and we can respond with the appropriate maintenance template
| for the incoming request below.
|
*/

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| We support a variety of autoloaders, though most people just use
| Composer. We'll simply require once the Composer autoloader so that
| everything is loaded and ready for the request.
|
*/

require __DIR__.'/../vendor/autoload.php';

// dd('Laravel bootstrapped'); // Temporary: Confirm Laravel's core is loading

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to the client's browser that has flushed the session and sent headers.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handle(Request::capture())->send();
