<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShippingCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shippingCompanies = [
            ['name' => 'DHL'],
            ['name' => 'FedEx'],
            ['name' => 'UPS'],
            ['name' => 'GLS']
        ];

        DB::table('shippingcompany')->insert($shippingCompanies);

        $provinces = DB::table('provinces')->get();

        foreach ($provinces as $province) {

            foreach ($shippingCompanies as $index => $company) {
                DB::table('shipping_provinces')->insert([
                    'shipping_company_id' => $index + 1,
                    'province_id' => $province->id
                ]);
            }

        }
    }
}
