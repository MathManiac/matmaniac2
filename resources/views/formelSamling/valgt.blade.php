@extends('formelSamling.master')

@section('formelSamlingContent')
    <table class="table table-bordered table-responsive">
        <thead>
            <tr>
                @foreach($columns as $column)
                    <th>{{ $column->name }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                @foreach($columns as $column)
                    <td>{{ $column->text }}</td>
                @endforeach
            </tr>
        </tbody>
    </table>
@endsection