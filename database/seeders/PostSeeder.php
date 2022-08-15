<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Author;
use App\Models\Category;
use App\Models\Game;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Attachment;

class PostSeeder extends Seeder
{
    protected $games;
    protected $categories;
    protected $authors;
    protected $tags;

    /**
     * Run the database seeds of pages and related blocks.
     *
     * @return void
     */
    public function run()
    {
        $this->games = Game::all();
        $this->categories = Category::all();
        $this->authors = Author::all();
        $this->tags = Tag::all();

        $schemas = [
            [
                'model' => [
                    'category_id' => $this->getCategory('news'),
                    'author_id' => $this->getAuthor('author-yaroslav'),
                    'game_id' => $this->getGame('witcher-3-wild-hunt'),
                    'is_active' => true,
                ],
                'translations' => [
                    'slug' => [
                        'en' => 'gerald-from-rivia-slept-with-a-new-witch',
                        'es' => 'gerald-de-rivia-se-acostó-con-una-nueva-bruja',
                    ],
                    'title' => [
                        'en' => 'Gerald From Rivia slept with a new witch',
                        'es' => 'Gerald de Rivia se acostó con una nueva bruja',
                    ],
                    'content' => [
                        'en' => 'In the new episode, Gerald of Rivia slept with a new witch.
                        Another powerful witch couldn\'t stand Gerald\'s cat eyes. Witcher again pretended he has amnesia and dived into her secret cave.',
                        'es' => 'En el nuevo episodio, Gerald de Rivia se acostó con una nueva bruja.
                        Otra bruja poderosa no podía soportar los ojos de gato de Gerald. Witcher volvió a fingir que tenía amnesia y se sumergió en su cueva secreta.'
                    ]
                ],
                'tags' => [$this->getTag('popular'), $this->getTag('recent')],
                'attachments' => [
                    'thumbnail' => [
                        [
                            'name' => 'witch-post-th-IkScYXATk5hFwz.webp',
                            'original_name' => 'witch-post-th.webp',
                            'type' => 'image',
                            'size' => '598464'
                        ]
                    ],
                    'images' => [
                        [
                            'name' => 'witch-post-th-1.jpeg',
                            'original_name' => 'witch-post-th-1.jpeg',
                            'type' => 'image',
                            'size' => '40673'
                        ],
                        [
                            'name' => 'witch-post-th-2.jpeg',
                            'original_name' => 'witch-post-th-2.jpeg',
                            'type' => 'image',
                            'size' => '5527'
                        ],
                        [
                            'name' => 'witch-post-th-3.jpeg',
                            'original_name' => 'witch-post-th-3.jpeg',
                            'type' => 'image',
                            'size' => '7113'
                        ],
                    ]
                ]
            ],
        ];

        foreach ($schemas as $schema) {
            $model = Post::create($schema['model']);
            $model->saveTranslations($schema['translations']);
            $model->tags()->attach($schema['tags']);
            foreach ($schema['attachments'] as $group => $attachments) {
                foreach ($attachments as $attachment) {
                    Attachment::create($attachment + [
                        'group' => $group,
                        'attachmentable_id' => $model->id,
                        'attachmentable_type' => Post::class
                    ]);
                }
            }
        }
    }

    private function getGame($key)
    {
        return $this->games->where('slug', $key)->value('id');
    }

    private function getCategory($key)
    {
        return $this->categories->where('slug', $key)->value('id');
    }

    private function getAuthor($key)
    {
        return $this->authors->where('slug', $key)->value('id');
    }

    private function getTag($key)
    {
        return $this->tags->where('slug', $key)->value('id');
    }
}
