<?php

namespace Database\Factories;

use App\Models\User;

use function PHPSTORM_META\map;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'title'=>$this->faker->sentence(5),
        'description'=>$this->faker->sentence(15),
        'image'=>$this->faker->avatar('foo'),
        'date_to_publish'=>now(),
        'status'=>'unpublish',
        'user_id'=>User::inRandomOrder()->first()->id
        ];
    }
}
