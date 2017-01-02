@extends('admin.tasks.master')

@section('validationContent')
    <h2>Validation</h2>
    <form method="post">
        {!! csrf_field() !!}
        <p>Available variables:
        <pre>{{ implode(', ', $variables) }}</pre>
        </p>
        <div class="form-group">
            <label>Enter the code to validate the users input.</label>
            @if($isAnswered)
                <p class="text-success"><b>Awesome!</b> All inputs have been answered.</p>
            @else
                <p class="text-danger tex2jax_ignore">The variable(s) {!! implode(', ', $requiredVariables) !!} needs to
                    be answered.</p>
            @endif
            <textarea name="variables" rows="10" style="width:100%"
                      id="generator">{{ old('variables', $task->validator) }}</textarea>
            <p class="text-info">Answers are automatically rounded to two decimal places.</p>
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
    </script>
@endsection