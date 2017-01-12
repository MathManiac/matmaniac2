@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-primary">
                    <div class="panel-heading"><i class="fa fa-bar-chart" aria-hidden="true"></i> Stats</div>
                    <div class="list-group">
                        <li class="list-group-item">Categories <span
                                    class="badge">{{ $statistics['categories'] }}</span></li>
                        <li class="list-group-item">Sub Categories <span
                                    class="badge">{{ $statistics['sub_categories'] }}</span></li>
                        <li class="list-group-item">Tasks <span class="badge">{{ $statistics['tasks'] }}</span></li>
                    </div>
                </div>
                <a data-toggle="modal" data-target="#newCategory" class="btn btn-primary btn-block"><i
                            class="fa fa-folder-open" aria-hidden="true"></i> New Category</a>
            </div>
            <div class="col-md-9">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Sub Categories</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td><a href="{{ route('admin.tasks.list', [$category->id]) }}">{{ ucfirst($category->name) }}</a></td>
                            <td>
                                @foreach($category->subExercises()->orderBy('name')->get() as $subExercise)
                                    <a href="{{ route('admin.tasks.list', [$category->id, $subExercise->id]) }}"
                                       class="label label-primary">{{ title_case(str_replace('-', ' ', $subExercise->name)) }}</a>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection