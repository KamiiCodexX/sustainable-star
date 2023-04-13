<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Delegate;

class DelegateSeeder extends Seeder
{
    public function run()
    {
        $delegates = [
            [
                'user_id' => 1,
                'company_id' => 1
            ],
            [
                'user_id' => 2,
                'company_id' => 2
            ]
        ];

        Delegate::insert($delegates);
    }
}
