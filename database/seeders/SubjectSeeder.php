<?php

namespace Database\Seeders;

use App\Models\ChoiceMultiple;
use App\Models\Paper;
use App\Models\Question;
use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subject::factory(10)
            ->has(Paper::factory()
                ->has(Question::factory()
                    ->has(ChoiceMultiple::factory()->count(4))
                    ->count(10))
                ->count(1))
            ->create();
    }
}
