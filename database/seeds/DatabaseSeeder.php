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
        ];

        foreach ($podcasts as $podcast) {
            Podcast::updateOrCreate([
                'url' => $podcast,
            ]);
        }
    }
}
