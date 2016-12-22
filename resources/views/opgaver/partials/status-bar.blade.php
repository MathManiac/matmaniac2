<div class="alert alert-info">
    @if(session()->exists('result-set'))
        <span>Opgave {{ session('result-set')->questions()->count() }}</span>
                <a href="{{ route('showResults') }}" class="btn btn-primary"><i class="fa fa-list-ol"></i> Vis Fremgang</a>
        <a href="{{ route('endResultSet', [$type, $subtype]) }}" class="pull-right btn btn-danger"><i class="fa fa-sign-out"></i> Afslut</a>
    @else
        <a href="{{ route('startResultSet', [$type, $subtype]) }}" class="btn btn-default">Ny Opgave</a>
    @endif
</div>