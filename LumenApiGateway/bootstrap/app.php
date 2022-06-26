<?php

require_once __DIR__.'/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

date_default_timezone_set(env('APP_TIMEZONE', 'UTC'));

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

// Enable these
$app->withFacades();

$app->withEloquent();

// -- Mis configuraciones 
/**
 * Registering Config file
 */
$app->configure('services');
$app->configure('auth');

// -- Con auth Cofnig estamos en capacidad de authetificar los tokens con passport para el acceso a nuestra api por medio de middlewares access tokens etc 

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Config Files
|--------------------------------------------------------------------------
|
| Now we will register the "app" configuration file. If the file exists in
| your configuration directory it will be loaded; otherwise, we'll load
| the default version. You may register other files below as needed.
|
*/

$app->configure('app');

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

// $app->middleware([
//     App\Http\Middleware\ExampleMiddleware::class
// ]);

// -- ESte middleware se ejecutará en cada ruta que queramos proteger de validaciones y ver a si en los headers authorization hay un token valido, usamos este middleware en web.php
$app->routeMiddleware([

    // -- middleware especial autentificar o identificar accss_token asociados a un User grant_type password desde la ruta y el modelo con el trait HasApiTokens
    'auth' => App\Http\Middleware\Authenticate::class,
    'client.credentials' => Laravel\Passport\Http\Middleware\CheckClientCredentials::class,
]);


/*


|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

// $app->register(App\Providers\AppServiceProvider::class);
// $app->register(App\Providers\EventServiceProvider::class);


// * Provedores Lumen Passport
// AuthServiceProvider nos ayuda a solicitar el registro de las rutas relacionadas con passport para crear tokens authentificar rutas 
$app->register(App\Providers\AuthServiceProvider::class);
$app->register(Laravel\Passport\PassportServiceProvider::class);
$app->register(Dusterio\LumenPassport\PassportServiceProvider::class);

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__.'/../routes/web.php';
});

return $app;
