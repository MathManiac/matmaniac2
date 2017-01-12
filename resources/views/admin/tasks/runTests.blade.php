@extends('admin.tasks.master')

@section('finalContent')
    <h2>Final
        <small>Run Tests</small>
    </h2>
    <a class="btn btn-sm btn-primary" href="{{ route('admin.tasks.final', $task->id) }}"><i
                class="fa fa-arrow-left"></i> Back</a>
    <h4>{{ $task->name }}</h4>
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
                    Variables: <i>
                        @foreach($question['shared'] as $variable => $content)
                            {{ camel_case(str_replace('answer', '', $variable)) }} = {{ $content }},
                        @endforeach
                    </i>
                    <hr>
                    @foreach($question['list'] as $index => $currentTask)
                        <b>{{ $index }}.</b>
                        {{ $currentTask['name'] }}: ${{ $currentTask['value'] }}$<br>
                        <div style="margin-left: 20px;">
                            @foreach($currentTask['input'] as $input)
                                ${{ $input['name'] }} = {{ $input['answer'] }}$<br>
                            @endforeach
                        </div>
                        @if($index != count($question['list']))
                            <hr>
                        @endif
                    @endforeach
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection