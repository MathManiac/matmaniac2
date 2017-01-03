<div class="panel panel-default">
    <div class="panel-heading"><i class="fa fa-chain"></i> Chain</div>
    <div class="panel-body">
        @foreach($previous as $prev)
            <p>
                <i class="fa fa-question-circle"></i> <b>{{ $prev['name'] }}</b>
                $${{ $prev['value'] }}$$
            </p>
            @foreach($prev['input'] as $input)
                <div class="form-group">
                    <label class="control-label">{{ $input['text'] }}</label>
                    @if($input['type'] == 'text')
                        @if($input['format'] == 'decimal')
                            <input type="text" value="{{ $input['answer'] }}" readonly class="form-control">
                            <p class="text-info">Up to Two Decimal Places</p>
                        @else
                            <div class="input-group">
                                <input type="text" value="{{ $input['answer'] }}" readonly class="form-control">
                                <div class="input-group-addon">%</div>
                            </div>
                        @endif
                    @endif
                </div>
            @endforeach
        @endforeach
    </div>
</div>