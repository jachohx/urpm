<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Illuminate\Foundation\Application(
    realpath(__DIR__.'/../')
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->configureMonologUsing(function($monolog) {
    $handlers = [
        //按logger的等级从高到低排,日志的级别按  level >= $this->level, @see Monolog\Handler\Monolog\Handler::isHandling
        (new Monolog\Handler\RotatingFileHandler(storage_path('/logs/laravel-error.log'), 0, Monolog\Logger::ERROR, false))
            ->setFormatter(new Monolog\Formatter\LineFormatter(null, null, true, true)),

        (new Monolog\Handler\RotatingFileHandler(storage_path('/logs/laravel-warning.log'), 0, Monolog\Logger::WARNING, false))
            ->setFormatter(new Monolog\Formatter\LineFormatter(null, null, true, true)),

        (new Monolog\Handler\RotatingFileHandler(storage_path('/logs/laravel-notice.log'), 0, Monolog\Logger::NOTICE, false))
            ->setFormatter(new Monolog\Formatter\LineFormatter(null, null, true, true)),

        (new Monolog\Handler\RotatingFileHandler(storage_path('/logs/laravel-info.log'), 0, Monolog\Logger::INFO, true))
            ->setFormatter(new Monolog\Formatter\LineFormatter(null, null, true, true)),

        (new App\Handlers\DBRotatingFileHandler(storage_path('/logs/laravel-db.log'), 0, App\Handlers\DBRotatingFileHandler::DB, true))
            ->setFormatter(new Monolog\Formatter\LineFormatter(null, null, true, true)),

        (new Monolog\Handler\RotatingFileHandler(storage_path('/logs/laravel-debug.log'), 0, Monolog\Logger::DEBUG, true))
            ->setFormatter(new Monolog\Formatter\LineFormatter(null, null, true, true)),
    ];
    $monolog->setHandlers($handlers);
});


/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/


return $app;
