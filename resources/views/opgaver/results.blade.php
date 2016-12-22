@extends('opgaver.master')

@section('opgaveContent')
    <a href="{{ route('valgtOpgave', [$resultSet->subExerciseType->exercise_type_id, $resultSet->sub_exercise_type_id]) }}"
       class="btn btn-primary btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i>Tilbage</a>
    <table style="margin-top:8px;" class="table table-bordered">
        <thead>
        <tr>
            <th>Nr.</th>
            <th>Spørgsmål</th>
            <th>Forsøg</th>
        </tr>
        </thead>
        <tbody>
        @foreach($results as $counter => $question)
            <tr @if($question->solved()) class="success" @else class="danger" @endif>
                <td>{{ $counter+1 }}</td>
                <td>@if( ! is_null($question->previous_id)) <i class="fa fa-level-up fa-flip-horizontal"
                                                               aria-hidden="true"></i> @endif <span onclick="$('.q{{$question->id}}').toggle();" style="cursor:pointer">{!! $question->text !!}</span>
                </td>
                <td>{{ $question->inputs()->count() }}</td>
            </tr>
            @foreach($question->inputs()->get() as $input)
                <tr style="display:none;" class="q{{$question->id}} @if($input->correct) success @else danger @endif">
                    <td colspan="3">
                    @foreach(json_decode($input->input) as $key => $try)
                            <dl style="margin-bottom: 0px;" class="dl-horizontal">
                                <dt>{{ $key }}</dt>
                                <dd>{{ $try }}</dd>

                            </dl>
                    @endforeach
                    </td>
                </tr>
            @endforeach
        @endforeach
        </tbody>
    </table>
@endsection