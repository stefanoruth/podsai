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

// Public
$router->view('welcome', 'welcome')->middleware('guest')->name('login');

// Auth
$router->get('logout', 'AuthController@logout')->middleware('auth')->name('logout');
$router->get('login', 'AuthController@redirectToProvider')->middleware('guest');
$router->get('login/google/callback', 'AuthController@handleProviderCallback')->middleware('guest');

// App
$router->get('/', 'HomeController@index')->middleware('auth')->name('home');
$router->middleware('auth')->prefix('api')->group(function ($router) {
    $router->resource('podcasts', 'PodcastController')->only('index', 'store', 'show');
    $router->resource('podcasts/subscriptions', 'PodcastSubscriptionController')->only('index', 'store', 'destroy');
    $router->resource('episodes', 'EpisodeController')->only('show');
    $router->resource('listens', 'ListenController')->only('store', 'show', 'update', 'destroy');
});