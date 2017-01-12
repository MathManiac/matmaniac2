@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">

                <a href="{{ route('admin.tasks.overview') }}" class="btn btn-warning btn-block"><i
                            class="fa fa-chevron-left"></i> Back to Categories</a>
                <a data-toggle="modal" data-target="#newCategory" class="btn btn-primary btn-block"><i
                            class="fa fa-folder-open" aria-hidden="true"></i> New Sub Category</a>
                <ul class="list-group" style="margin-top:20px;">
                    @foreach($subExercises as $exercise)
                        <a href="{{ route('admin.tasks.list', [$exerciseType->id, $exercise->id]) }}"
                           class="list-group-item @if( ! is_null($subExercise) && $subExercise->id == $exercise->id) active @endif">
                            <span class="badge">{{ count($exercise->tasks) }}</span>
                            {{ title_case(str_replace('-', ' ', $exercise->name)) }}
                        </a>
                    @endforeach
                </ul>
                @if( ! is_null($subExercise))
                    <a href="{{ route('admin.tasks.create', [null, 'new-category'=>$subExercise->id]) }}"
                       class="btn btn-primary btn-block"><i class="fa fa-plus" aria-hidden="true"></i> Create Task</a>
                    <a class="btn btn-default btn-block"><i class="fa fa-download"></i> Import Tasks</a>
                @endif
            </div>
            <div class="col-md-9">
                @if( ! is_null($subExercise))
                    <div class="btn-group">
                        <a class="btn btn-xs btn-success"><i class="fa fa-arrow-circle-down"></i> Download Tasks</a>
                    </div>
                    <div class="btn-group pull-right">
                        <a class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete Category</a>
                    </div>
                @endif
                <table class="table">
                    <thead>
                    <tr>
                        <th>Tasks</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if( ! is_null($subExercise))
                        @foreach($listOfTasks as $task)
                            <tr>
                                <td><a href="{{ route('admin.tasks.final', [$task['task']->id]) }}"
                                       style="margin-left: {{ $task['level'] * 20 }}px;">{{ $task['task']->name }}</a>
                                </td>
                                <td>{{ ucfirst($task['task']->status) }}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal" id="newCategory" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <form action="{{ route('admin.tasks.create-sub-category', $exerciseType->id) }}" class="modal-content"
                  method="post">
                {!! csrf_field() !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">New Sub Category</h4>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" name="subCategory" class="form-control" id="exampleInputEmail1"
                                   placeholder="Name">
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

@section('scripts')
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    @if(session()->has('success'))
        <script>swal("Success", "{{ session('success') }}", "success")</script>
    @endif
    @if(session()->has('error'))
        <script>swal("Error", "{{ addslashes(session('error')) }}", "error")</script>
    @endif
    @if(session()->has('warning'))
        <script>swal("Warning", "{!! addslashes(session('warning')) !!}", "warning")</script>
    @endif
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css ">
@endsection