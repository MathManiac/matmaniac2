@extends('admin.tasks.master')

@section('finalContent')
    <h2>Final
        <small>Run Tests</small>
    </h2>
    <a class="btn btn-sm btn-primary" href="{{ route('admin.tasks.final', $task->id) }}"><i
                class="fa fa-arrow-left"></i> Back</a>
    <h4>{{ $task->options['text'] }}</h4>
    <table class="table table-bordered table-responsive">
        <thead>
        <th width="5%">No.</th>
        <th>Test</th>
        </thead>
        <tbody>
        @foreach($questions as $index => $question)
            <tr>
                <td>{{ $index+1 }}</td>
                <td>
                    <b>${{ $question['value'] }}$</b>
                    <dl>
                        @foreach($question['input'] as $input)
                            <dt>{{ $input['text'] }}</dt>
                            <dd>{{ $input['answer'] }}</dd>
                        @endforeach
                    </dl>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection