@extends('admin.tasks.master')

@section('finalContent')
    <h2>Final</h2>
    <p>Task is done! Run tests to see if you always get the output you expect, once you're ready, change the status.</p>
    <a href="{{ route('admin.tasks.runTests', [$task->id]) }}" class="btn btn-primary"><i class="fa fa-flask" aria-hidden="true"></i> Run Test</a>
@endsection