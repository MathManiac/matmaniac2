@extends('admin.tasks.master')

@section('inputContent')
    <h2>Input</h2>
    <form method="post">
        @for($i = 0; $i < count($inputs); $i++)
            @if($inputs[$i]['type'] == 'text')
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Text</label>
                            <input type="text" placeholder="Hvad er A?" name="input[{{ $i }}][text]" value="{{ $inputs[$i]['text'] }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" placeholder="a" name="input[{{ $i }}][name]" value="{{ $inputs[$i]['name'] }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Format</label>
                            <select class="form-control" name="input[{{ $i }}][name]">
                                <option value="decimal" @if($inputs[$i]['format'] == 'decimal') selected @endif>Decimal</option>
                                <option value="percent" @if($inputs[$i]['format'] == 'percent') selected @endif>Percent</option>
                            </select>
                        </div>
                    </div>
                </div>
            @endif
        @endfor
    </form>
    <form method="post">
        {!! csrf_field() !!}
        @if(session()->has('new_input'))
            @if(session('new_input') == 'text')
                <input type="hidden" name="new[type]" value="text">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Text</label>
                            <input type="text" placeholder="Hvad er A?" name="new[text]" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" placeholder="a" name="new[name]" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Format</label>
                            <select class="form-control" name="new[format]">
                                <option value="decimal">Decimal</option>
                                <option value="percent">Percent</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Save</label>
                            <button class="form-control btn btn-success"><i class="fa fa-save"></i></button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12" style="top: -12px">
                        <a href="{{ route('admin.tasks.inputs', [$task->id]) }}"
                           class="btn btn-xs btn-primary">Discard</a>
                    </div>
                </div>
            @endif
        @endif
        <h4>Add Input</h4>
        <a href="{{ route('admin.tasks.addInput', [$task->id, 'type'=>'text']) }}"
           class="btn @if(session()->has('new_input')) disabled @endif btn-sm btn-primary">Text
            Input</a>
    </form>
@endsection