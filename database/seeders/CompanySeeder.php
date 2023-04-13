<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run()
    {
        // Company::factory()
        //     ->count(10)
        //     ->create();

        $companies = [
            [
                'owner_id' => 1,
                'name' => 'Company A',
                'email' => 'companya@example.com',
                'contact' => '1234567890',
                'country' => 'USA',
                'description' => 'This is company A',
                'logo' => 'companya.jpg'
            ],
            [
                'owner_id' => 2,
                'name' => 'Company B',
                'email' => 'companyb@example.com',
                'contact' => '0987654321',
                'country' => 'UK',
                'description' => 'This is company B',
                'logo' => 'companyb.jpg'
            ]
        ];

        Company::insert($companies);
    }
}
