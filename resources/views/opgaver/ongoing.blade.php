@extends('opgaver.master')

@section('opgaveContent')
    <div class="panel panel-primary">
        <div class="panel-heading">Allerede igang</div>
        <div class="panel-body">
            Du er allerede igang med {{ strtolower(trans("tasks.subExercises.$subtype->name")) }}.
            <a href="{{ route('valgtOpgave', [session('result-set')->subExerciseType->exercise_type_id , session('result-set')->subExerciseType->id]) }}"
               class="btn-sm btn-success">Gå til opgaven</a> <a
                    href="{{ route('endResultSet', [session('result-set')->subExerciseType->exercise_type_id , session('result-set')->subExerciseType->id]) }}"
                    class="btn-sm btn-danger">Afslut opgaven</a>
        </div>
    </div>
@endsection