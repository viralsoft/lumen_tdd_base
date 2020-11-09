<?php

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

$router->group([
    'prefix' => 'auth'
], function ($router) {
    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');

    $router->group([
        'middleware' => 'auth',
    ], function ($router) {

//        $router->post('logout', 'AuthController@logout');
        $router->delete('logout', 'AuthController@logout');
        $router->post('users/create', 'ProfileController@store');
        $router->get('users/{id}', 'ProfileController@index');
        $router->patch('users/{id}', 'ProfileController@update');
//        $router->post('refresh', 'AuthController@refresh');
//        $router->post('me', 'AuthController@me');
    });

});
