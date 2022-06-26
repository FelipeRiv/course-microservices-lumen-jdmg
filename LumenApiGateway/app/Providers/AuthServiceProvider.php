<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Dusterio\LumenPassport\LumenPassport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        // -- comented
        // $this->app['auth']->viaRequest('api', function ($request) {
        //     if ($request->input('api_token')) {
        //         return User::where('api_token', $request->input('api_token'))->first();
        //     }
        // });

        // ## Registramos rutas que nos permiten crear tokens acceder y validarlos, usamos el provedor y registramos rutas apartir del sistema de rutas actual de Lumen  

        // * llamamos al metodo routes de lumen y le pasamos el enrutador o el sistema de rutas de lumen para que funcione
        LumenPassport::routes($this->app->router);

        // Hay que indicar el mecanismo para el sistema  de authenticacion con el archivo de configuracion  como el configuracion de services pero haremos uno nuevo llamado auth proveniente de lumen  
        // vendor/laravel/lumen-framework/config/auth.php se duplica este en la carpeta config en app



    }
}
