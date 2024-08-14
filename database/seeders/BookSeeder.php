<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class BookSeeder extends Seeder
{

    /**
     * @return void
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            DB::table('book')->insert([
                'name' => $faker->name,
                'title' => $faker->sentence,
                'wrote_at' => $faker->dateTime(),
                'author_id' => DB::table('author')->inRandomOrder()->first()->id,
                'file_path' => $faker->sentence,
                'text' => $faker->paragraph
            ]);
        }
    }
}
