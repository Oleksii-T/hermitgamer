<?php

namespace App\Actions;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Game;
use App\Models\Author;
use App\Models\Category;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap
{
    // const CHANGE_FREQUENCY_ALWAYS = 'always';
    // const CHANGE_FREQUENCY_HOURLY = 'hourly';
    // const CHANGE_FREQUENCY_DAILY = 'daily';
    // const CHANGE_FREQUENCY_WEEKLY = 'weekly';
    // const CHANGE_FREQUENCY_MONTHLY = 'monthly';
    // const CHANGE_FREQUENCY_YEARLY = 'yearly';
    // const CHANGE_FREQUENCY_NEVER = 'never';

    public static function run()
    {
        $path = public_path('sitemap.xml');
        $staticPagesDate = Carbon::parse('2024-04-01');

        $sm = Sitemap::create()
            ->add(Url::create('/')->setLastModificationDate($staticPagesDate))
            ->add(Url::create(route('rate'))->setLastModificationDate($staticPagesDate))
            ->add(Url::create(route('contact-us'))->setLastModificationDate($staticPagesDate))
            ->add(Url::create(route('about-us'))->setLastModificationDate($staticPagesDate))
            ->add(Url::create(route('privacy'))->setLastModificationDate($staticPagesDate))
            ->add(Url::create(route('terms'))->setLastModificationDate($staticPagesDate));

        foreach (Post::publised()->get() as $post) {
            $sm->add(Url::create(route('posts.show', $post))->setLastModificationDate($post->updated_at));
        }

        foreach (Category::all() as $category) {
            $sm->add(Url::create(route('categories.show', $category))->setLastModificationDate($category->updated_at));
        }

        foreach (Author::all() as $author) {
            $sm->add(Url::create(route('authors.show', $author))->setLastModificationDate($author->updated_at));
        }

        foreach (Game::all() as $game) {
            $sm->add(Url::create(route('games.show', $game))->setLastModificationDate($game->updated_at));
        }

        $sm->writeToFile($path);

        // Read the file into a string
        $content = file_get_contents($path);
    
        // Remove lines containing '<priority>' using regex
        $content = preg_replace('/.*<priority>.*\n/', '', $content);
        $content = preg_replace('/.*<changefreq>.*\n/', '', $content);
    
        // Write the modified string back to the file
        file_put_contents($path, $content);
    }
}
