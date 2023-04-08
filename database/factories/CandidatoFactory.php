<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CandidatoFactory extends Factory
{

    public function definition()
    {
        return [
            'first_name' => $this->faker->name(),
            'full_name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'job_title' => $this->randomJobTitle(),
            'experiences' => $this->faker->text(200),
            'skills' => json_encode($this->randomSkills()),
            'experience_level' => $this->randomExperienceLevel(),
        ];
    }

    public function randomJobTitle()
    {
        $job_titles = [
            'Desenvolvedor Full Stack',
            'Desenvolvedor Front End',
            'Desenvolvedor Back End'
        ];

        $count_job_titles = count($job_titles) - 1;
        $random_index = rand(0, $count_job_titles);

        return $job_titles[$random_index];
    }

    public function randomSkills()
    {
        $skills = [
            "Vue.Js",
            "React.Js",
            "React Native",
            "Laravel",
            "Adonis",
            "Angular",
            ".NET",
            "Lumen",
            "TypeScript",
            "Python",
            "Django",
            "Java",
            "Socket.IO"
        ];

        $count_skills = count($skills) - 1;
        $random_skills = [];

        while (count($random_skills) <= 5) {
            $random_index = rand(0, $count_skills);

            if (!in_array($skills[$random_index], $random_skills)) {
                $random_skills[] = $skills[$random_index];
            }
        }

        return $random_skills;
    }

    public function randomExperienceLevel()
    {
        $experience_levels = [
            'junior',
            'pleno',
            'senior'
        ];

        $random_index = rand(0, 2);

        return $experience_levels[$random_index];
    }
}
