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
    return "Hello";
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('object', ['uses' => 'DataObjectController@index']);
    $router->get('object/{key}', ['uses' => 'DataObjectController@show']);
    $router->post('object', ['uses' => 'DataObjectController@post']);
});