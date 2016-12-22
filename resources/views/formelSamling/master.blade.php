@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
                    @foreach(\App\Category::all() as $category)
                        <a class="list-group-item @if($currentCategory == $category->id) active @endif"
                           href="{{ route('formel-samling', [$category->id]) }}">{{ $category->name }}</a>
                        @if($currentCategory == $category->id)
                            @foreach($category->subjects()->get() as $subject)
                                <a class="list-group-item @if($currentSubject == $subject->id) active @endif"
                                   href="{{ route('formel-samling-valgt', [$category->id, $subject->id]) }}"
                                   class="list-group-item">->{{ $subject->title }}</a>
                            @endforeach
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="col-md-9">
                @yield('formelSamlingContent')
            </div>
        </div>
    </div>
@endsection