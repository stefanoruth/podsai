<?php

use App\Podcast;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $podcasts = [
            'https://rss.simplecast.com/podcasts/1486/rss',
            'http://testandcode.com/rss',
            'https://rss.simplecast.com/podcasts/279/rss',
            'https://rss.simplecast.com/podcasts/351/rss',
            'https://rss.simplecast.com/podcasts/335/rss',
            'http://twentypercent.fm/rss',
            'http://feeds.feedburner.com/PhpRoundtable',
            'http://www.dr.dk/mu/Feed/mads-monopolet-podcast.xml?format=podcast&limit=500',
            'https://feed.syntax.fm/rss',
            'https://rss.simplecast.com/podcasts/1356/rss',
        ];

        foreach ($podcasts as $podcast) {
            Podcast::updateOrCreate([
                'url' => $podcast,
            ]);
        }
    }
}
