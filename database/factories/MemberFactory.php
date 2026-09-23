<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    protected $model = Member::class;

    public function definition(): array
    {
        $gender = fake()->randomElement(['L', 'P']);
        $classes = ['X', 'XI', 'XII'];
        $majors = ['IPA', 'IPS', 'Bahasa', 'TKJ', 'RPL', 'MM', 'AKL', 'OTKP', 'BDP'];

        return [
            'member_code' => 'AGT' . fake()->unique()->numerify('######'),
            'nis' => fake()->unique()->numerify('##########'),
            'name' => $gender === 'L' ? fake('id_ID')->firstNameMale() . ' ' . fake('id_ID')->lastName() : fake('id_ID')->firstNameFemale() . ' ' . fake('id_ID')->lastName(),
            'gender' => $gender,
            'class' => fake()->randomElement($classes) . ' ' . fake()->randomElement($majors) . ' ' . fake()->numberBetween(1, 4),
            'major' => fake()->randomElement($majors),
            'phone' => fake('id_ID')->phoneNumber(),
            'address' => fake('id_ID')->address(),
            'status' => 'active',
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }
}
