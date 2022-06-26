<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

// * Excecute seeds php artisan db:seed
// * Excecute migration plus seeders droping tables php artisan migrate:fresh --seed drop tables and create records with seeds
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Book::factory()
              ->count(5) // 150
              ->create();



        // $this->call('UsersTableSeeder');
    } 
}
