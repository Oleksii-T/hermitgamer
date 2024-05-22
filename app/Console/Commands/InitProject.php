<?php

namespace App\Console\Commands;

use App\Models\Game;
use App\Models\Page;
use App\Models\Post;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Console\Command;
use App\Actions\GenerateSitemap;

class InitProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-project';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Page::getAllSlugs(true);
        Post::getAllSlugs(true);
        Game::getAllSlugs(true);
        Author::getAllSlugs(true);
        Category::getAllSlugs(true);
        GenerateSitemap::run();
    }
}
