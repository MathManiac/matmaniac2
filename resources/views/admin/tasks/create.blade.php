@extends('admin.tasks.master')

@section('generatorContent')
    <h2>Generator</h2>
    <form method="post">
        {!! csrf_field() !!}
        <div class="form-group">
            <label>Question</label>
            <input type="text" name="question" value="{{ old('question', is_null($task) ? '' : $task->options['text']) }}"
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
        <a href="#" class="btn btn-success">Next <i class="fa fa-arrow-right"></i></a>
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
    </script>
@endsection