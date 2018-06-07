module.exports = [
    {
        path: '/',
        component: require('./views/Home'),
    },
    {
        path: '/my-podcasts',
        component: require('./views/MyPodcasts'),
    },
    {
        path: '/my-podcasts/episodes',
        component: require('./views/MyEpisodes'),
    },
    {
        path: '/podcasts',
        component: require('./views/Podcasts'),
    },
    {
        path: '/podcasts/:id',
        component: require('./views/PodcastShow'),
        props: true,
    },
    {
        path: '/podcasts/:podcastId/episodes/:episodeId',
        component: require('./views/EpisodeShow'),
        props: true,
    },
    {
        path: '/profile',
        component: require('./views/Profile'),
    },
];