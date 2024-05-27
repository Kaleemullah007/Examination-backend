<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $number = rand(0, 1);
        $types = array('radio', 'checkbox');
        return [
            'question' => fake()->sentence(),
            'question_type' => $types[$number],
            'correct_answer' => 'correct'
        ];
    }
}
