<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


// -- Group Routes to protect them with client.credetials middleware in bootsrap/app.php when accessing theses routes you need to be authenticated because of client-credentials middlware
$router->group( [ 'middleware' => 'client.credentials' ], function() use($router) {

        
    /**
     * Authors Routes
     */
    $router->get('/authors', 'AuthorController@index');
    $router->post('/authors', 'AuthorController@store');
    $router->put('/authors/{author}', 'AuthorController@update');
    $router->patch('/authors/{author}', 'AuthorController@update');
    $router->get('/authors/{author}', 'AuthorController@show');
    $router->delete('/authors/{author}', 'AuthorController@destroy');

    /**
     * Books Routes
     */
    $router->get('/books', 'BookController@index');
    $router->post('/books', 'BookController@store');
    $router->put('/books/{book}', 'BookController@update');
    $router->patch('/books/{book}', 'BookController@update');
    $router->get('/books/{book}', 'BookController@show');
    $router->delete('/books/{book}', 'BookController@destroy');

    /**
     * Users Routes
     */
    $router->get('/users', 'UserController@index');
    $router->post('/users', 'UserController@store');
    $router->put('/users/{user}', 'UserController@update');
    $router->patch('/users/{user}', 'UserController@update');
    $router->get('/users/{user}', 'UserController@show');
    $router->delete('/users/{user}', 'UserController@destroy');

});



/**
 * ## Only access_tokens linked to an User
 * -- Routes protected by user credentials  this middleware requires that the  access_Token is linked to an user  grant_type password, we have to identify the users in the User Model with that access_token with a Trait called -> HasApiTokens  and then enable the middleware auth in bootstrap/app.php 
 */
$router->group(['middleware' => 'auth:api'], function() use ($router){
    // me() V 59
    $router->get('/users/me', 'UserController@me');
});
