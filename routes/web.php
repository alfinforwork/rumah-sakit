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
    $json = [
        'message' => 'Selamat datang di website rumah sakit',
        'version' => $router->app->version(),
    ];
    return response()->json($json);
});
$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->group(['prefix' => 'dashboard'], function () use ($router) {
        $router->get('/data', 'DashboardController@index');
        $router->get('/sampah_terlaris', 'DashboardController@sampah_terlaris');
    });
});
$router->get('/lupapassword', 'LupapasswordController@index');

$router->post('/login', 'AuthController@authenticate');

$router->get('/tes', function () use ($router) {
    return view('email');
});
