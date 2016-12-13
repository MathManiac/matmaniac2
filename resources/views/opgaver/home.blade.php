@extends('opgaver.master')

@section('opgaveContent')
    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="jumbotron">
        <h1>Opgaver</h1>
        <p>I venstre side kan du finde de emner som der er opgaver til.</p>

        <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a></p>

    </div>
@endsection

