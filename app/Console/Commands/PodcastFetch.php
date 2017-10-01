<?php

namespace App\Console\Commands;

use App\Jobs\UpdatePodcast;
use App\Podcast;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class PodcastFetch extends Command
{
    use DispatchesJobs;

    protected $signature = 'podcast:fetch {--id=}';
    protected $description = 'Fetch data from all podcasts';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $start = microtime(true);

        Podcast::when($this->option('id'), function($query){
            $query->where('id', $this->option('id'));
        })->get()->when(true, function($podcasts){
            $this->bar = $this->output->createProgressBar($podcasts->count());

            return $podcasts;
        })->each(function($podcast){
            $this->dispatch(new UpdatePodcast($podcast));
            $this->bar->advance();
        });

        $this->bar->finish();
        $this->line("\nDuration: ".number_format(microtime(true)-$start, 2).' sec');
    }
}
