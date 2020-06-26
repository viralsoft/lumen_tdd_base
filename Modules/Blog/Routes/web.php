<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$router->group([
    'middleware' => 'auth',
    'prefix'     => 'posts',
], function ($router) {
    // | GET|HEAD  | posts              | App\Http\Controllers\PostController@index   |
    $router->addRoute(['GET'], '/', 'PostController@index');
    // | POST      | posts              | App\Http\Controllers\PostController@store   |
    $router->addRoute('POST', '/', 'PostController@store');
    // | GET|HEAD  | posts/{id} | App\Http\Controllers\PostController@show    |
    $router->addRoute(['GET'], '/{id}', 'PostController@show');
    // | PUT|PATCH | posts/{id} | App\Http\Controllers\PostController@update  |
    $router->addRoute(['PUT', 'PATCH'], '/{id}', 'PostController@update');
    // | DELETE    | posts/{id} | App\Http\Controllers\PostController@destroy |
    $router->addRoute('DELETE', '/{id}', 'PostController@destroy');
    // | PUT|PATCH | posts/{id}/toggleStatus | App\Http\Controllers\PostController@toggleStatus  |
    $router->addRoute(['PUT', 'PATCH'], '/{id}/toggleStatus', 'PostController@toggleStatus');
});
