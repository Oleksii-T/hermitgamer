<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds of pages and related blocks.
     *
     * @return void
     */
    public function run()
    {
        $schemas = [
            [
                'model' => [
                    'in_menu' => true,
                    'order' => 1
                ],
                'translations' => [
                    'name' => [
                        'en' => 'News',
                        'es' => 'Noticias'
                    ],
                    'slug' => [
                        'en' => 'news',
                        'es' => 'noticias',
                    ]
                ]
            ],
            [
                'model' => [
                    'in_menu' => true,
                    'order' => 2
                ],
                'translations' => [
                    'name' => [
                        'en' => 'Reviews',
                        'es' => 'Reseñas'
                    ],
                    'slug' => [
                        'en' => 'reviews',
                        'es' => 'resenas',
                    ]
                ]
            ],
            [
                'model' => [
                    'in_menu' => true,
                    'order' => 3
                ],
                'translations' => [
                    'name' => [
                        'en' => 'Guides',
                        'es' => 'Guías'
                    ],
                    'slug' => [
                        'en' => 'guides',
                        'es' => 'guias',
                    ]
                ]
            ],
            [
                'model' => [
                    'in_menu' => true,
                    'order' => 4
                ],
                'translations' => [
                    'name' => [
                        'en' => 'Entertainment',
                        'es' => 'Entretenimiento'
                    ],
                    'slug' => [
                        'en' => 'entertainment',
                        'es' => 'entretenimiento',
                    ]
                ]
            ],
            [
                'model' => [
                    'in_menu' => true,
                    'order' => 5
                ],
                'translations' => [
                    'name' => [
                        'en' => 'Features',
                        'es' => 'Características'
                    ],
                    'slug' => [
                        'en' => 'features',
                        'es' => 'caracteristicas',
                    ]
                ]
            ],
            [
                'model' => [
                    'in_menu' => false,
                    'order' => 6
                ],
                'translations' => [
                    'name' => [
                        'en' => 'Tech',
                        'es' => 'Tecnología'
                    ],
                    'slug' => [
                        'en' => 'tech',
                        'es' => 'tecnologia',
                    ]
                ]
            ],
            [
                'model' => [
                    'in_menu' => false,
                    'order' => 7
                ],
                'translations' => [
                    'name' => [
                        'en' => 'Video',
                        'es' => 'Video'
                    ],
                    'slug' => [
                        'en' => 'video',
                        'es' => 'video',
                    ]
                ]
            ],
            [
                'model' => [
                    'in_menu' => false,
                    'order' => 8
                ],
                'translations' => [
                    'name' => [
                        'en' => 'Quizzes',
                        'es' => 'Cuestionarios'
                    ],
                    'slug' => [
                        'en' => 'quizzes',
                        'es' => 'cuestionarios',
                    ]
                ]
            ],
        ];

        foreach ($schemas as $schema) {
            $model = Category::create($schema['model']);
            $model->saveTranslations($schema['translations']);
        }

    }
}
