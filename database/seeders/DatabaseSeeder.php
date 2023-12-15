<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Add this import statement
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        //call product seeder and vendor seeder
        $sql = File::get(database_path('seeds/full_provinces.sql'));

        DB::unprepared($sql); // Use the DB facade to execute the SQL query

        $this->call([
            UserSeeder::class,
            ProductSeeder::class,
            CategoriesTableSeeder::class,
            ShippingCompanySeeder::class,
        ]);

    }
}
