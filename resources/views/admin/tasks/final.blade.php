@extends('admin.tasks.master')

@section('finalContent')
    <h2>Final</h2>
    <div class="row">
        <div class="col-md-8">
            <label>Options</label>
            <p>Task is done! Run tests to see if you always get the output you expect, once you're ready, change the
                status.</p>
            <a href="{{ route('admin.tasks.runTests', [$task->id]) }}" class="btn btn-primary"><i class="fa fa-flask"
                                                                                                  aria-hidden="true"></i>
                Run Test</a>
            <a href="{{ route('admin.tasks.archive', [$task->id]) }}" class="btn btn-success"><i class="fa fa-download"></i> Download Task</a>
            <a href="{{ route('admin.tasks.archive', [$task->id]) }}" class="btn btn-default pull-right"><i class="fa fa-archive"></i> Archive
                Task</a>
        </div>
        <div class="col-md-4">
            <form method="post">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="unfinished" @if($task->status == 'unfinished') selected @endif>Unfinished
                        </option>
                        <option value="disabled" @if($task->status == 'disabled') selected @endif>Offline</option>
                        <option value="testing" @if($task->status == 'testing') selected @endif>Beta</option>
                        <option value="available" @if($task->status == 'available') selected @endif>Online</option>
                    </select>
                </div>
                @if($task->status != 'unfinished')
                    <p class="text-info">The task can only be changed while in the "Unfinished State".</p>
                @endif
                <button class="btn btn-primary">Change Status</button>
            </form>
        </div>
    </div>
    <hr>
    <h3><i class="fa fa-link"></i> Chain</h3>
    <div class="row">
        <div class="col-md-4">
            <h4>New</h4>
            <a href="{{ route('admin.tasks.create', [null, 'previous'=>$task->id]) }}"
               class="btn btn-default btn-block"><i class="fa fa-external-link-square" aria-hidden="true"></i> Create
                Follow Up Task</a>
        </div>
        <div class="col-md-8">
            <h4>List</h4>
            <ul class="list-unstyled">
                @foreach($task->previousList() as $previousTask)
                    <li>-
                        <a href="{{ route('admin.tasks.final', [$previousTask->id]) }}">{{ $previousTask->name }}</a>
                    </li>
                @endforeach
                <li>-
                    {{ $task->name }}
                </li>
                @foreach($task->upcoming()->get() as $upcomingTask)
                    <li style="padding-left:20px">-
                        <a href="{{ route('admin.tasks.final', [$upcomingTask->id]) }}">{{ $upcomingTask->name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection