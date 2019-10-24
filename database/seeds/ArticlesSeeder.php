<?php

use Illuminate\Database\Seeder;
use App\Articles;

class ArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Articles::truncate();

        $faker = \Faker\Factory::create();

        for ($i=0; $i < 30; $i++) {
            Articles::create([
                'title' => $faker->sentence,
                'description' => $faker->paragraph,
            ]);
        }
    }
}
