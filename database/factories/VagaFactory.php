<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VagaFactory extends Factory
{

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'company' => $this->faker->company(),
            'description' => $this->faker->text(200),
            'requirements' => $this->faker->text(250),
            'salary' => $this->randomSalary(),
            'type' => $this->randomType(),
            'modality' => $this->randomModality(),
            'status' => 'active'
        ];
    }

    public function randomSalary()
    {
        return floatval(mt_rand(2500, 7000));
    }

    public function randomType()
    {
        $types = [
            'remote',
            'in_person',
            'hybrid',
        ];

        $random_index = rand(0, 2);

        return $types[$random_index];
    }

    public function randomModality()
    {
        $modalities = [
            'clt',
            'pj',
            'freelancer',
        ];

        $random_index = rand(0, 2);

        return $modalities[$random_index];
    }
}
