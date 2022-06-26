<?php

namespace Database\Seeders;
use App\Models\Author;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Author::factory()
                ->count(50)
                ->create();

    }
}

// TODO DOCS: Check changes in Laravel 8 
// 1st https://laravel.com/docs/8.x/database-testing#defining-model-factories
// 2nd https://laravel.com/docs/8.x/seeding#using-model-factories

// php artisan db:seed
