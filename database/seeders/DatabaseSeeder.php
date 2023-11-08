<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
/*
        \App\Models\User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',

        ]);
        

        \App\Models\Vendor::factory()->create([[
            'Name' => 'Estimazon store',
            'Description' => 'This is vendor 1',
            'Address' => '123 Main St',
            'Phone' => '555-1234',
            'Email' => 'store@estimazon.com',
            'NIF' => '12345678A'
        ],
        [
            'Name' => 'Miravia store',
            'Description' => 'This is vendor 2',
            'Address' => '456 Elm St',
            'Phone' => '555-5678',
            'Email' => 'store@miravia.com',
            'NIF' => '87654321B'
        ],
        [
            'Name' => 'Paquita store',
            'Description' => 'This is vendor 3',
            'Address' => '789 Oak St',
            'Phone' => '555-9012',
            'Email' => 'store@paquita.com',
            'NIF' => '11111111C'
        ]]);
        */

        //call product seeder and vendor seeder


        $this->call([
            VendorSeeder::class,
            ProductSeeder::class,
            CategoriesTableSeeder::class,
        ]);

    }
}
