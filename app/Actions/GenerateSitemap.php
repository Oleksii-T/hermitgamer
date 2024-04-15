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
        // master sitemap
        $sm = Sitemap::create()
            ->add(Url::create('/')
                ->setLastModificationDate(Carbon::parse('2024-04-01'))
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(1.0))
            ->add(Url::create(route('rate'))
                ->setLastModificationDate(Carbon::parse('2024-04-01'))
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.7))
            ->add(Url::create(route('contact-us'))
                ->setLastModificationDate(Carbon::parse('2024-04-01'))
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.7))
            ->add(Url::create(route('about-us'))
                ->setLastModificationDate(Carbon::parse('2024-04-01'))
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.7))
            ->add(Url::create(route('privacy'))
                ->setLastModificationDate(Carbon::parse('2024-04-01'))
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.7))
            ->add(Url::create(route('terms'))
                ->setLastModificationDate(Carbon::parse('2024-04-01'))
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.7));
            // ->add(Url::create('/sitemap-posts.xml')
            //     ->setLastModificationDate(now())
            //     ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            //     ->setPriority(0.9))

        foreach (Post::publised()->get() as $post) {
            $sm->add(Url::create(route('posts.show', $post))
                ->setLastModificationDate($post->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(0.9));
        }

        foreach (Category::all() as $category) {
            $sm->add(Url::create(route('categories.show', $category))
                ->setLastModificationDate($category->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(0.8));
        }

        foreach (Author::all() as $author) {
            $sm->add(Url::create(route('authors.show', $author))
                ->setLastModificationDate($author->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(0.8));
        }

        foreach (Game::all() as $game) {
            $sm->add(Url::create(route('games.show', $game))
                ->setLastModificationDate($game->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(0.8));
        }

        $sm->writeToFile(public_path('sitemap.xml'));
    }
}
