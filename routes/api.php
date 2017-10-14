<?php

$router->middleware('auth')->group(function ($router) {
    $router->resource('podcasts', 'PodcastController')->only('index', 'store', 'show');
    $router->resource('podcasts/subscriptions', 'PodcastSubscriptionController')->only('index', 'store', 'destroy');
    $router->resource('episodes', 'EpisodeController')->only('show');
    $router->resource('episodes/listeners', 'EpisodeListenerController')->only('store', 'update', 'destroy');
});