@extends('admin.tasks.master')

@section('inputContent')
    <h2>Input</h2>
    <form method="post" action="{{ route('admin.tasks.updateInputs', $task->id) }}">
        {!! csrf_field() !!}
        @if(count($inputs) > 0)
            <h4>Current Input</h4>
        @endif
        @for($i = 0; $i < count($inputs); $i++)
            @if($inputs[$i]['type'] == 'text')
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Text</label>
                            <input type="text" placeholder="Hvad er A?" name="input[{{ $i }}][text]"
                                   value="{{ $inputs[$i]['text'] }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" placeholder="a" name="input[{{ $i }}][name]"
                                   value="{{ $inputs[$i]['name'] }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Format</label>
                            <select class="form-control" name="input[{{ $i }}][format]">
                                <option value="decimal" @if($inputs[$i]['format'] == 'decimal') selected @endif>
                                    Decimal
                                </option>
                                <option value="percent" @if($inputs[$i]['format'] == 'percent') selected @endif>
                                    Percent
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Text</label>
                            <input type="text" placeholder="Hvad er A?" name="input[{{ $i }}][text]"
                                   value="{{ $inputs[$i]['text'] }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" placeholder="a" name="input[{{ $i }}][name]"
                                   value="{{ $inputs[$i]['name'] }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Format</label>
                            <a href="{{ route('admin.tasks.addInputSelection', [$task->id, 'input'=>$i]) }}"
                               class="btn btn-block btn-primary"><i class="fa fa-plus"></i> Add Option</a>
                        </div>
                    </div>
                </div>
                @for($k = 0; $k < count($inputs[$i]['options']); $k++)
                    <div class="row">
                        <div class="col-md-offset-1 col-md-2">
                            <div class="form-group">
                                <label style="margin-top:30px;">Option {{ $k+1 }}</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Text</label>
                                <input type="text" placeholder="a"
                                       name="input[{{ $i }}][options][{{ $k }}][value]"
                                       value="{{ $inputs[$i]['options'][$k]['value'] }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" placeholder="a" name="input[{{ $i }}][options][{{ $k }}][name]"
                                       value="{{ $inputs[$i]['options'][$k]['name'] }}" class="form-control">
                            </div>
                        </div>
                    </div>
                @endfor
            @endif
            <div class="row">
                <div class="col-lg-12" style="top:-12px">
                    <a class="btn btn-xs btn-primary @if($i == 0) disabled @endif"
                       href="{{ route('admin.tasks.inputAction', [$task->id, 'action'=>'move-up', 'id' => $i]) }}"><i
                                class="fa fa-arrow-up"></i> Move Up</a> <a
                            class="btn btn-xs btn-primary @if($i+1 == count($inputs)) disabled @endif"
                            href="{{ route('admin.tasks.inputAction', [$task->id, 'action'=>'move-down', 'id' => $i]) }}"><i
                                class="fa fa-arrow-down"></i> Move Down</a> <a
                            href="{{ route('admin.tasks.inputAction', [$task->id, 'action'=>'delete', 'id' => $i]) }}"
                            class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Remove</a>
                </div>
            </div>
        @endfor
        @if(count($inputs) > 0)
            <button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Update</button>
            <hr>
        @endif
    </form>
    <form method="post">
        {!! csrf_field() !!}
        @if(session()->has('new_input'))
            <h4>New Input</h4>
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
            @elseif(session('new_input') == 'select')
                <input type="hidden" name="new[type]" value="select">
                <input type="hidden" name="new[format]" value="list">
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
                            <label>Save</label>
                            <button class="form-control btn btn-success"><i class="fa fa-save"></i></button>
                        </div>
                    </div>
                </div>
                <template id="selectOptions" class="row">
                    <div>
                        <div class="col-md-offset-3 col-md-3">
                            <div class="form-group">
                                <label>Text</label>
                                <input type="text" placeholder="a" name="new[options][text][0]"
                                       class="optionName form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" placeholder="a" name="new[options][name][0]" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Remove</label>
                                <button type="button" class="btn btn-block btn-danger">Remove</button>
                            </div>
                        </div>
                    </div>
                </template>
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
        <a href="{{ route('admin.tasks.addInput', [$task->id, 'type'=>'select']) }}"
           class="btn @if(session()->has('new_input')) disabled @endif btn-sm btn-primary">Select Input</a>
    </form>
@endsection