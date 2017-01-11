<div class="panel panel-default">
    <div class="panel-heading">Preview</div>
    <div class="panel-body">
        <p>
            <i class="fa fa-question-circle"></i> <b>{{ $preview['text'] }}</b>
        </p>
        @if($preview['value'] != '')
            $${{ $preview['value'] }}$$
        @endif
        @foreach($task->options['input'] as $input)
            <div class="form-group">
                <label class="control-label">{{ $input['text'] }}</label>
                @if($input['type'] == 'text')
                    @if($input['format'] == 'decimal')
                        <input type="text" value="{{ $resolver->getResultForInput($input['name'], $task) }}"
                               class="form-control">
                        <p class="text-info">Up to Two Decimal Places</p>
                    @else
                        <div class="input-group">
                            <input type="text"
                                   value="{{ $resolver->getResultForInput($input['name'], $task) }}"
                                   class="form-control">
                            <div class="input-group-addon">%</div>
                        </div>
                    @endif
                @elseif($input['type'] == 'select')
                    <select class="form-control">
                        @foreach($input['options'] as $option)
                            <option @if($resolver->getResultForInput($input['name'], $task) == $option['name']) selected @endif>{{ $option['value'] }}</option>
                        @endforeach
                    </select>
                @endif
            </div>
        @endforeach
    </div>
</div>