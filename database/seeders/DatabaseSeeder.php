<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * @return void
     */
    public function run(): void
    {
        $this->call([
            AuthorSeeder::class,
            BookSeeder::class,
            PublishHouseSeeder::class,
            PublishHouseBookSeeder::class,
        ]);
    }
}
