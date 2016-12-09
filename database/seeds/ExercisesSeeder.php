<?php

use Illuminate\Database\Seeder;

class ExercisesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exercise = \App\ExerciseType::create([
            'id' => 1,
            'name' => 'algebra'
        ]);

        $exercise->subExercises()->create([
            'id' => 1,
            'name' => 'addition'
        ]);

        $exercise = \App\ExerciseType::create([
            'id' => 2,
            'name' => 'fractions'
        ]);

        $exercise->subExercises()->create([
            'id' => 20,
            'name' => 'multiply-two-fractions'
        ]);

        $exercise->subExercises()->create([
            'id' => 21,
            'name' => 'one-fraction-with-a-number'
        ]);

        $exercise = \App\ExerciseType::create([
            'id' => 3,
            'name' => 'equations'
        ]);

        $exercise->subExercises()->create([
            'id' => 40,
            'name' => 'equation-x-on-one-side'
        ]);

        $exercise->subExercises()->create([
            'id' => 41,
            'name' => 'equation-x-on-both-sides'
        ]);
    }
}
