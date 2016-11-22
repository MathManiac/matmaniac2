@extends('opgaver.master')

@section('opgaveContent')
    @include('opgaver.partials.status-bar', compact('type', 'subtype'))
    @if(session()->exists('result-set'))
        @if(session()->has('math_error'))
            <div class="alert alert-danger">
                {{ trans('alerts.'.session()->get('math_error')) }}
            </div>
        @endif
        @if(session()->has('math_solution'))
            <div class="alert alert-success">
                {{ trans('alerts.'.session()->get('math_solution')) }}
            </div>
        @endif

        $${{ $opg }}$$

        <form action="{{ route("tjek-resultat") }}" method="POST" xmlns="http://www.w3.org/1999/html">
            {!! csrf_field() !!}

            <input type="text" name="resultat">
            <a class="pull-right btn btn-danger">Spring Over</a>
            <input type="submit">
        </form>
    @endif
@endsection