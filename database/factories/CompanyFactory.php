<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition()
    {
        return [
            'owner_id' => rand(1, 10),
            'name' => $this->faker->company,
            'email' => $this->faker->unique()->companyEmail,
            'contact' => $this->faker->phoneNumber,
            'country' => $this->faker->country,
            'description' => $this->faker->sentence,
            'logo' => $this->faker->imageUrl(),
        ];
    }
}
