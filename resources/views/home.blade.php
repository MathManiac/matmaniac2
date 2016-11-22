@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div align="center">
                        <h1>Velkommen til {{ isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email }}</h1>
                    </div>
                </div>

                <div class="panel-body">
                    HER SKAL STÅ ET ELLER ANDET EVT ET BILLEDE
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
