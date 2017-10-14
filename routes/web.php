<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$router->get('/', 'HomeController@index')->name('home');

// Auth
$router->get('logout', 'AuthController@logout')->middleware('auth')->name('logout');
$router->get('login', 'AuthController@redirectToProvider')->name('login');
$router->get('login/google/callback', 'AuthController@handleProviderCallback');