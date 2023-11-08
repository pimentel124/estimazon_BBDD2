<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
   {
       DB::table('categories')->insert([
           'name' => 'Tecnología',
           'slug' => 'tecnologia',
           'description' => 'Los mejores dispositivos tecnológicos',
           'parent_id' => null,
           'created_at' => now(),
           'updated_at' => now(),
       ]);


       //crete more categories
       DB::table('categories')->insert([
           'name' => 'Smartphones',
           'slug' => 'smartphones',
           'description' => 'Los mejores smartphones',
           'parent_id' => 1,
           'created_at' => now(),
           'updated_at' => now(),
       ]);

       DB::table('categories')->insert([
           'name' => 'Smartwatches',
           'slug' => 'smartwatches',
           'description' => 'Los mejores smartwatches',
           'parent_id' => 1,
           'created_at' => now(),
           'updated_at' => now(),
       ]);

       DB::table('categories')->insert([
           'name' => 'Televisores',
           'slug' => 'televisores',
           'description' => 'Los mejores televisores',
           'parent_id' => 1,
           'created_at' => now(),
           'updated_at' => now(),
       ]);

       DB::table('categories')->insert([
           'name' => 'Accesorios',
           'slug' => 'accesorios',
           'description' => 'Los mejores accesorios',
           'parent_id' => null,
           'created_at' => now(),
           'updated_at' => now(),
       ]);

       DB::table('categories')->insert([
           'name' => 'Bisuteria',
           'slug' => 'bisuteria',
           'description' => 'La mejor bisutería',
           'parent_id' => 5,
           'created_at' => now(),
           'updated_at' => now(),
       ]);
   }
}
