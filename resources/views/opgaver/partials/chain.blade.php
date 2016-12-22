<div class="list-group">
    @for($i = 0; $i < count(session('chain.list')); $i++)
        <div class="list-group-item">
            <h5 class="list-group-item-heading"><span class="text-muted">{{ $i+1 }}.</span> {!! session('chain.list')[$i]['text'] !!}</h5>
            <p class="list-group-item-text">
                $${{ session('chain.list')[$i]['value'] }}$$
                @foreach(session('chain.list')[$i]['result'] as $variable => $result)
                    @if ( ! is_numeric($result))
                        {{ trans('tasks.expressions.' . $result) }}
                    @else
                        $${{ $variable . ' = ' . $result}}$$
                    @endif
                @endforeach
            </p>
        </div>
    @endfor
</div>
