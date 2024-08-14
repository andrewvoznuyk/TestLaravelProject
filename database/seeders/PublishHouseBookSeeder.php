<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PublishHouseBookSeeder extends Seeder
{

    /**
     * @return void
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            DB::table('publishHouseBook')->insert([
                'book_id' => DB::table('book')->inRandomOrder()->first()->id,
                'publish_house_id' => DB::table('publishHouse')->inRandomOrder()->first()->id,
            ]);
        }
    }
}
