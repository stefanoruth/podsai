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
$router->get('login/google', 'AuthController@redirectToProvider')->name('login');
$router->get('login/google/callback', 'AuthController@handleProviderCallback');


$router->middleware('auth')->group(function ($router) {
    $router->resource('podcasts', 'PodcastController')->only('index', 'create', 'show');
    $router->resource('podcasts/subscriptions', 'PodcastSubscriptionController')->only('index', 'store', 'destroy');
    $router->resource('episodes', 'EpisodeController')->only('index', 'show');
    $router->resource('episodes/listeners', 'EpisodeListenerController')->only('store', 'update', 'destroy');
});
