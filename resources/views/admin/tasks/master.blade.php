@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="container-fluid">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                @yield('generatorContent', 'stuff')
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                @yield('inputContent', '<h2><a>Input</a></h2>')
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="text-muted">Final</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">Type</div>
                </div>
                @unless(is_null($task))
                    @include('admin.tasks.partials.preview')
                @endunless
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
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css ">
@endsection