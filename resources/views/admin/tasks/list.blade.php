@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <a href="{{ route('admin.tasks.create', [null, 'new-category'=>$subExercise->id]) }}"
                   class="btn btn-primary btn-block"><i class="fa fa-plus" aria-hidden="true"></i> Create Task</a>
                <ul class="list-group" style="margin-top:20px;">
                    @foreach($subExercises as $exercise)
                        <a href="{{ route('admin.tasks.list', [$exercise->id]) }}"
                           class="list-group-item @if($subExercise->id == $exercise->id) active @endif">
                            <span class="badge">{{ count($exercise->tasks) }}</span>
                            {{ $exercise->name }}
                        </a>
                    @endforeach
                </ul>
                <a data-toggle="modal" data-target="#newCategory" class="btn btn-primary btn-block"><i
                            class="fa fa-folder-open" aria-hidden="true"></i> New Sub Category</a>
                <a class="btn btn-warning btn-block"><i class="fa fa-chevron-left"></i> Back to Categories</a>
            </div>
            <div class="col-md-9">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Tasks</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($listOfTasks as $task)
                        <tr>
                            <td><a href="{{ route('admin.tasks.final', [$task['task']->id]) }}"
                                   style="margin-left: {{ $task['level'] * 20 }}px;">{{ $task['task']->options['text'] }}</a>
                            </td>
                            <td>{{ ucfirst($task['task']->status) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal" id="newCategory" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <form action="{{ route('admin.tasks.create-sub-category') }}" class="modal-content" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">New Sub Category</h4>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" name="subCategory" class="form-control" id="exampleInputEmail1" placeholder="Email">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success pull-left">Create</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
@endsection