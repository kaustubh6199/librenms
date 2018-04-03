<?php

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Register The Composer Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader
| for our application. We just need to utilize it! We'll require it
| into the script here so we do not have to manually load any of
| our application's PHP classes. It just feels great to relax.
|
*/

@include __DIR__ . '/../vendor/autoload.php';

if (!class_exists(\App\Preflight::class)) {
    require __DIR__ . '/../app/Preflight.php';
}

\App\Preflight::checkDependencies();
