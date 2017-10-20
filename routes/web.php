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
$router->get('login/callback', 'AuthController@handleProviderCallback')->middleware('guest');

// App
$router->view('/', 'home')->middleware('auth')->name('home');
$router->middleware('auth')->prefix('api')->group(function ($router) {
    $router->resource('podcasts/trending', 'TrendingPodcastController')->only('index');
    $router->resource('podcasts/subscriptions', 'PodcastSubscriptionController')->only('index', 'store', 'destroy');
    $router->resource('podcasts', 'PodcastController')->only('index', 'store', 'show');
    $router->resource('episodes/completions', 'EpisodeCompletionController')->only('store', 'show', 'update', 'destroy');
    $router->resource('episodes/latest', 'LatestEpisodeController')->only('index');
    $router->resource('episodes', 'EpisodeController')->only('show');
});