@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
                    <!--<a href="#" class="list-group-item active">
                        Cras justo odio
                    </a>
                    <a href="#" class="list-group-item">Gange to brøker</a>
                    <a href="#" class="list-group-item">Morbi leo risus</a>
                    <a href="#" class="list-group-item">Porta ac consectetur ac</a>
                    <a href="#" class="list-group-item">Vestibulum at eros</a>-->
                    @foreach(\App\ExerciseType::all() as $exercise)
                        <a class="list-group-item"
                           href="{{ route('opgaver', [$exercise->id]) }}">{{ trans('tasks.exercises.'.$exercise->name) }}</a>
                        @if(array_key_exists('type', Route::current()->parameters()))
                            @if(Route::current()->parameters()['type'] == $exercise->id)
                                @foreach(\App\SubExerciseType::where('exercise_type_id', $exercise->id)->get() as $subExercise)
                                    <a href="{{ route('valgtOpgave', [$exercise->id, $subExercise->id]) }}"
                                       class="list-group-item">{{ trans('tasks.subExercises.'.$subExercise->name) }}</a>
                                @endforeach
                            @endif
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="col-md-9">

                @yield('opgaveContent')
            </div>
        </div>
    </div>
@endsection