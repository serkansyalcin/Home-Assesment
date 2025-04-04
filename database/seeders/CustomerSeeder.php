<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(base_path('example-data/customers.json'));
        $customers = json_decode($json, true);

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
} 