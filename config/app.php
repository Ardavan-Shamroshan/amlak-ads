<?php
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

    'APP_TITLE' => 'mvc project',

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

    'BASE_URL' => 'http://localhost:8000',

    /*
   |--------------------------------------------------------------------------
   | Application Direction
   |--------------------------------------------------------------------------
   |
   |  This value is the base direction of your application. This value is used when the
   | framework needs to place the application's direction in a notification or
   | any other location as required by the application or its packages.
   |
   */

    'BASE_DIR' => dirname(__DIR__),

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

    'providers' => [
        \App\Providers\SessionProvider::class,
        \App\Providers\AppServiceProvider::class,
    ]
];