<div class="panel panel-default">
    <div class="panel-heading"><i class="fa fa-chain"></i> Chain<a href="#" data-toggle="modal" data-target="#variables"
                                                                   class="pull-right">View Variables</a></div>
    <div class="panel-body">
        @foreach(session('chain.list') as $id => $chainItem)
            <p>
                <i class="fa fa-question-circle"></i> <b><a href="{{ route('admin.tasks.final', $id) }}">{{ $chainItem['name'] }}</a></b>
                $${{ $chainItem['value'] }}$$
            </p>
            @foreach($chainItem['input'] as $input)
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


<!-- Modal -->
<div class="modal" id="variables" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Variables</h4>
            </div>
            <div class="modal-body">

                <dl class="dl-horizontal">
                    @foreach(session('chain.shared') as $variable => $content)
                        <dt>${{ $variable }}</dt>
                        <dd>{{ $content }}</dd>
                    @endforeach
                </dl>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>