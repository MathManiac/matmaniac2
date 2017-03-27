@extends('admin.tasks.master')

@section('generatorContent')
    <h2>Generator</h2>
    <form method="post">
        @if(request()->has('new-category'))
            <input type="hidden" name="new-category" value="{{ request('new-category') }}">
        @endif
        {!! csrf_field() !!}
        @if(request()->has('previous'))
            <input type="hidden" name="previous" value="{{ request('previous') }}">
        @endif
        @if(request()->has('conditional') || ! is_null($task) && ! is_null($task->chain_condition))
            <div class="form-group">
                <label>Condition</label>
                <textarea name="condition" id="condition" style="width:100%">{{ old('condition', is_null($task) ? '' : $task->chain_condition) }}</textarea>
                <p class="text-info">The variable <b>$condition</b> must be true for this question to follow up.</p>
            </div>
        @endif
        <div class="form-group">
            <label>Header</label>
            <input type="text" name="question" value="{{ old('question', is_null($task) ? '' : $task->name) }}"
                   class="form-control">
        </div>
        <div class="form-group">
            <label>Variables</label>
            <textarea name="variables" rows="10" style="width:100%"
                      id="generator">{{ old('variables', is_null($task) ? '' : $task->generator) }}</textarea>
            <p class="text-info">Enter php code to generate necessary variables for the mathmatic
                question.</p>
        </div>
        <div class="form-group">
            <label>Math Question</label>
            <input type="text" value="{{ old('math-question', is_null($task) ? '' : $task->options['value']) }}"
                   name="math-question" class="form-control">
            <p class="text-info">Use LaTeX. Variables from above should be referenced here.</p>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
    </form>
@endsection

@section('scripts')
    @parent
    <script type="text/javascript" src="{{ asset('js/edit_area/edit_area_full.js') }}"></script>
    <script type="text/javascript">
        editAreaLoader.init({
            id: "generator",
            syntax: "php",
            start_highlight: true,
            allow_toggle: false
        });
        @if(request()->has('conditional'))
            editAreaLoader.init({
            id: "condition",
            syntax: "php",
            start_highlight: true,
            allow_toggle: false
        });
        @endif
    </script>
@endsection