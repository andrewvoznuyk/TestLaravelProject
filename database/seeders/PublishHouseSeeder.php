<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PublishHouseSeeder extends Seeder
{

    /**
     * @return void
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 5; $i++) {
            DB::table('publishHouse')->insert([
                'name' => $faker->company,
                'description' => $faker->paragraph,
                'founded_at' => $faker->dateTime(),
                'owner' => $faker->name,
            ]);
        }
    }
}
