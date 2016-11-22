<div class="alert alert-info">
    @if(session()->exists('result-set'))
        <span>Opgave {{ session('result-set')->questions()->count() }}</span>
        <a href="{{ route('endResultSet', [$type, $subtype]) }}" class="pull-right btn btn-danger">Afslut</a>
    @else
        <a href="{{ route('startResultSet', [$type, $subtype]) }}" class="btn btn-default">Ny Opgave</a>
    @endif
</div>