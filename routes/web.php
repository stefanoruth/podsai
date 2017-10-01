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

$router->view('/', 'app');
$router->get('logout', 'AuthController@logout');
$router->get('login/google', 'AuthController@redirectToProvider')->name('login');
$router->get('login/google/callback', 'AuthController@handleProviderCallback');

$router->get('podcast', function(){
    return \App\User::with('podcasts', 'episodes')->get();
    return \App\Podcast::with('episodes.users', 'users')->get();
});