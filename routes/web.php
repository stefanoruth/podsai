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

// Auth
Route::get('logout', 'AuthController@logout')->middleware('auth')->name('logout');
Route::get('login', 'AuthController@redirectToProvider')->middleware('guest');
Route::get('login/callback', 'AuthController@handleProviderCallback')->middleware('guest');

// App
Route::middleware('auth')->prefix('api')->group(function () {
    Route::resource('subscriptions', 'SubscriptionController')->only('index', 'store', 'destroy');
    Route::resource('completions', 'CompletionController')->only('index', 'store', 'show', 'update', 'destroy');
    Route::resource('podcasts/top', 'TopPodcastController')->only('index');
    Route::resource('podcasts', 'PodcastController')->only('index', 'store', 'show');
    Route::resource('podcasts/{podcast}/episodes', 'PodcastEpisodeController')->only('show');
    Route::resource('episodes/latest', 'LatestEpisodeController')->only('index');
    Route::resource('users', 'UserController')->only('index');
});

// Public
Route::get('{uri}', 'MainController@index')->name('login')->where('uri', '^(?:(?!api).*)');
