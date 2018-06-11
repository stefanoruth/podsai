module.exports = [
    {
        path: '/',
        component: require('./views/Catalog'),
    },
    {
        path: '/my-podcasts',
        component: require('./views/MyPodcasts'),
    },
    {
        path: '/playlist',
        component: require('./views/Playlist'),
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