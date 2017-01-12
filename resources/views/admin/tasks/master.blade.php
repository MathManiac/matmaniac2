@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <ol class="breadcrumb" style="margin:0px;">
                            <li><a href="#">{{ ucfirst($breadcrumbs['category']->name) }}</a></li>
                            <li><a href="{{ route('admin.tasks.list', [$breadcrumbs['category']->id, $breadcrumbs['subCategory']->id]) }}">{{ ucfirst($breadcrumbs['subCategory']->name) }}</a></li>
                            @if(is_null($task))
                                <li class="active">New Task</li>
                            @else
                                <li class="active">{{ $task->name }}</li>
                            @endif
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @if(is_null($task))
                            @yield('generatorContent', '<h2><a href="'.route('admin.tasks.create', is_null($task) ? [] : $task->id).'">Generator</a></h2>')
                        @else
                            @if($task->status == 'unfinished')
                                @yield('generatorContent', '<h2><a href="'.route('admin.tasks.create', is_null($task) ? [] : $task->id).'">Generator</a></h2>')
                            @else
                                <h2 class="text-muted">Generator</h2>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @if(is_null($task))
                            <h2 class="text-muted">Input</h2>
                        @else
                            @if($task->status == 'unfinished')
                                @yield('inputContent', '<h2><a href="'.route('admin.tasks.inputs', $task->id).'">Input</a></h2>')
                            @else
                                <h2 class="text-muted">Input</h2>
                            @endif
                        @endif

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @if(is_null($task))
                            <h2 class="text-muted">Validation</h2>
                        @else
                            @if($task->status == 'unfinished')
                                @if(count($task->options['input']))
                                    @yield('validationContent', '<h2><a href="'.route('admin.tasks.validation', $task->id).'">Validation</a></h2>')
                                @else
                                    <h2 class="text-muted">Validation</h2>
                                @endif
                            @else
                                <h2 class="text-muted">Validation</h2>
                            @endif
                        @endif

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @if(is_null($task))
                            <h2 class="text-muted">Final</h2>
                        @else
                            @if($task->allInputsAnswered() && count($task->options['input']) > 0)
                                @yield('finalContent', '<h2><a href="'.route('admin.tasks.final', $task->id).'">Final</a></h2>')
                            @else
                                <h2 class="text-muted">Final</h2>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                @unless(is_null($task))
                    @include('admin.tasks.partials.preview')
                @endunless
                @if(request()->has('previous') || ( ! is_null($task)  && ! is_null($task->chained_to)))
                    @include('admin.tasks.partials.chain')
                @endif
                @yield('sidebar')
            </div>
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