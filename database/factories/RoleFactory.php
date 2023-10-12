<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => new Sequence('admin', 'user', 'author'),
            'persian_name' => new Sequence(['admin' => 'ادمین'], ['user' => 'کاربر عادی'], ['author' => 'نویسنده']),
            'status' => fake()->boolean()
        ];
    }
}
