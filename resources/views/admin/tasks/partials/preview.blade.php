<div class="panel panel-default">
    <div class="panel-heading">Preview</div>
    <div class="panel-body">
        <p>
            <i class="fa fa-question-circle"></i> <b>{{ $task->options['text'] }}</b>
        </p>
        $${{ $genOptions->generateFormula($task)['value'] }}$$
        @foreach($task->options['input'] as $input)
            <div class="form-group">
                <label class="control-label">{{ $input['text'] }}</label>
                @if($input['type'] == 'text')
                    @if($input['format'] == 'decimal')
                        <input type="text" value="{{ $genOptions->getResultForInput($input['name'], $task) }}" readonly class="form-control">
                        <p class="text-info">Up to Two Decimal Places</p>
                    @else
                        <div class="input-group">
                            <input type="text" value="{{ $genOptions->getResultForInput($input['name'], $task) }}" readonly class="form-control">
                            <div class="input-group-addon">%</div>
                        </div>
                    @endif
                @endif
            </div>
        @endforeach
    </div>
</div>