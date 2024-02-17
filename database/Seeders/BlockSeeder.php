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
                ''
            ]
        ];

        foreach ($schemas as $schema) {
            $model = Block::create($schema['model']);
            $model->saveTranslations($schema['translations']);
        }

    }
}
