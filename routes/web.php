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

$router->get('reservations/{user_id}', 'ReservationController@all');
$router->get('reservation/{id}', 'ReservationController@show');
$router->post('reservation', 'ReservationController@store');
$router->patch('reservation/{id}', 'ReservationController@update');

// guests
$router->post('guest', 'GuestController@store');
$router->patch('guest/{id}', 'GuestController@update');
$router->delete('guest/{id}', 'GuestController@destroy');

// menus
$router->post('menu', 'MenuController@store');
$router->patch('menu', 'MenuController@update');
$router->delete('menu', 'MenuController@destroy');

// System
$router->get('allreservations', 'SystemController@allReservations');
$router->get('allguests', 'SystemController@allGuests');
$router->get('guest/{id}', 'SystemController@guest');
$router->get('allmenus', 'SystemController@allMenus');

/*
|--------------------------------------------------------------------------
| Restaurant Routes
|--------------------------------------------------------------------------
*/
$router->get('restaurant/reservations/{restaurant_id}', 'RestaurantReservationController@all');

$router->get('restaurant/tables/{restaurant_id}/{date}', 'TablesController@index');
$router->get('restaurant/table/{restaurant_id}/{table}', 'TablesController@show');