@extends('layouts.app')

@section('content')
    <form action="{{ route("tjek-resultat") }}" method="POST">
        {!! csrf_field() !!}
    {{ $opg }}
        <input type="hidden" name="hash" value="{{ $hash }}">
        <input type="hidden" name="question" value="{{ $question }}">
        <input type="text" name="resultat">
        <input type="submit">
    </form>
@endsection