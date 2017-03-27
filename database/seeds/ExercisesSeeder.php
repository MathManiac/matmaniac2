<?php

use Illuminate\Database\Seeder;

class ExercisesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exercise = \App\ExerciseType::create([
            'id'   => 1,
            'name' => 'algebra'
        ]);

        $exercise->subExercises()->create([
            'id'   => 1,
            'name' => 'addition'
        ]);

        $exercise = \App\ExerciseType::create([
            'id'   => 2,
            'name' => 'fractions'
        ]);

        $exercise->subExercises()->create([
            'id'   => 20,
            'name' => 'multiply-two-fractions'
        ]);

        $exercise->subExercises()->create([
            'id'   => 21,
            'name' => 'one-fraction-with-a-number'
        ]);

        $exercise = \App\ExerciseType::create([
            'id'   => 3,
            'name' => 'equations'
        ]);

        $exercise->subExercises()->create([
            'id'   => 40,
            'name' => 'equation-x-on-one-side'
        ]);

        $exercise->subExercises()->create([
            'id'   => 41,
            'name' => 'equation-x-on-both-sides'
        ]);

        $exercise->subExercises()->create([
            'id'   => 42,
            'name' => 'equation-x-with-brackets'
        ]);

        $exercise->subExercises()->create([
            'id'   => 43,
            'name' => 'equation-x-in-nominator'
        ]);

        $exercise->subExercises()->create([
            'id'   => 44,
            'name' => 'equation-x-in-nominator-and-coeff'
        ]);

        $exercise->subExercises()->create([
            'id'   => 45,
            'name' => 'equation-x-in-denominator'
        ]);

        $exercise->subExercises()->create([
            'id'   => 46,
            'name' => 'equation-x-in-denominator-and-coeff'
        ]);

        $exercise = \App\ExerciseType::create([
            'id'   => 4,
            'name' => 'functions',
        ]);

        $exercise->subExercises()->create([
            'id'   => 60,
            'name' => 'two-points-exponential'
        ]);

        $exercise->subExercises()->create([
            'id'   => 62,
            'name' => 'two-points-potens'
        ]);

        $exercise->subExercises()->create([
            'id'   => 61,
            'name' => 'second-poly'
        ]);

        $exercise->subExercises()->create([
            'id'   => 999,
            'name' => 'test'
        ]);

        $exercise = \App\ExerciseType::create([
            'id'   => 5,
            'name' => 'differentiation',
        ]);

        $exercise->subExercises()->create([
            'id'   => 51,
            'name' => 'diff-power-functions'
        ]);
    }
}
