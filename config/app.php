<?php

/*
 | !!!! DO NOT EDIT THIS FILE !!!!
 |
 | You can change settings by setting them in the environment or .env
 | If there is something you need to change, but is not available as an environment setting,
 | request an environment variable to be created upstream or send a pull request.
 */

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Facade;

return [

    /*
     |--------------------------------------------------------------------------
     | Application Name
     |--------------------------------------------------------------------------
     |
     | This value is the name of your application. This value is used when the
     | framework needs to place the application's name in a notification or
     | any other location as required by the application or its packages.
     |
     */

    'name' => env('APP_NAME', 'LibreNMS'),

    /*
     |--------------------------------------------------------------------------
     | Application Environment
     |--------------------------------------------------------------------------
     |
     | This value determines the "environment" your application is currently
     | running in. This may determine how you prefer to configure various
     | services the application utilizes. Set this in your ".env" file.
     |
     */

    'env' => env('APP_ENV', 'production'),

    /*
     |--------------------------------------------------------------------------
     | Application Debug Mode
     |--------------------------------------------------------------------------
     |
     | When your application is in debug mode, detailed error messages with
     | stack traces will be shown on every error that occurs within your
     | application. If disabled, a simple generic error page is shown.
     |
     */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
     |--------------------------------------------------------------------------
     | Application URL
     |--------------------------------------------------------------------------
     |
     | This URL is used by the console to properly generate URLs when using
     | the Artisan command line tool. You should set this to the root of
     | your application so that it is used when running Artisan tasks.
     |
     */

    'url' => env('APP_URL', 'http://localhost'),

    'asset_url' => env('ASSET_URL', null),

    /*
     |--------------------------------------------------------------------------
     | Application Timezone
     |--------------------------------------------------------------------------
     |
     | Here you may specify the default timezone for your application, which
     | will be used by the PHP date and date-time functions. We have gone
     | ahead and set this to a sensible default for you out of the box.
     |
     */

    'timezone' => ini_get('date.timezone') ?: 'UTC', // use existing timezone

    /*
     |--------------------------------------------------------------------------
     | Application Locale Configuration
     |--------------------------------------------------------------------------
     |
     | The application locale determines the default locale that will be used
     | by the translation service provider. You are free to set this value
     | to any of the locales which will be supported by the application.
     |
     */

    'locale' => env('APP_LOCALE', 'en'),

    /*
     |--------------------------------------------------------------------------
     | Application Fallback Locale
     |--------------------------------------------------------------------------
     |
     | The fallback locale determines the locale to use when the current one
     | is not available. You may change the value to correspond to any of
     | the language folders that are provided through your application.
     |
     */

    'fallback_locale' => 'en',

    /*
     |--------------------------------------------------------------------------
     | Faker Locale
     |--------------------------------------------------------------------------
     |
     | This locale will be used by the Faker PHP library when generating fake
     | data for your database seeds. For example, this will be used to get
     | localized telephone numbers, street address information and more.
     |
     */

    'faker_locale' => 'en_US',

    /*
     |--------------------------------------------------------------------------
     | Encryption Key
     |--------------------------------------------------------------------------
     |
     | This key is used by the Illuminate encrypter service and should be set
     | to a random, 32 character string, otherwise these encrypted strings
     | will not be safe. Please do this before deploying an application!
     |
     */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    |
    | These configuration options determine the driver used to determine and
    | manage Laravel's "maintenance mode" status. The "cache" driver will
    | allow maintenance mode to be controlled across multiple machines.
    |
    | Supported drivers: "file", "cache"
    |
    */

    'maintenance' => [
        'driver' => 'file',
        // 'store'  => 'redis',
    ],

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => ServiceProvider::defaultProviders()->merge([
        /*
          * Laravel Framework Service Providers...
          */

        /*
          * Package Service Providers...
          */

        /*
          * LibreNMS Service Providers...
          */
        App\Providers\ConfigServiceProvider::class,
        App\Providers\ErrorReportingProvider::class, // This should always be after the config is loaded
        App\Providers\AppServiceProvider::class,
        App\Providers\CliServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        App\Providers\ComposerServiceProvider::class,
        App\Providers\DatastoreServiceProvider::class,
        App\Providers\SnmptrapProvider::class,
        App\Providers\PluginProvider::class,
    ])->toArray(),

    /*
     |--------------------------------------------------------------------------
     | Class Aliases
     |--------------------------------------------------------------------------
     |
     | This array of class aliases will be registered when this application
     | is started. However, feel free to register as many as you wish as
     | the aliases are "lazy" loaded so they don't hinder performance.
     |
     */

    'aliases' => Facade::defaultAliases()->merge([
        'Debugbar' => Barryvdh\Debugbar\Facades\Debugbar::class,
        'Flare' => Spatie\LaravelIgnition\Facades\Flare::class,
        'Redis' => Illuminate\Support\Facades\Redis::class,

        // LibreNMS
        'DeviceCache' => \App\Facades\DeviceCache::class,
        'Permissions' => \App\Facades\Permissions::class,
        'PluginManager' => \App\Facades\PluginManager::class,
        'Rrd' => \App\Facades\Rrd::class,
        'SnmpQuery' => \App\Facades\FacadeAccessorSnmp::class,
    ])->forget([
        'Http', // don't use Laravel Http facade, LibreNMS has its own wrapper
    ])->toArray(),

    'charset' => env('CHARSET', ini_get('php.output_encoding') ?: ini_get('default_charset') ?: 'UTF-8'),
];
