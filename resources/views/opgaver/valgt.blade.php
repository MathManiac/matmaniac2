@extends('opgaver.master')

@section('opgaveContent')
    <!--<h1>{{ trans('tasks.subExercises.'.$subtype->name) }}</h1>-->
    @include('opgaver.partials.status-bar', compact('type', 'subtype'))
    @if( ! session()->has('question'))
        <p>Klik på 'Ny opgave' når du vil i gang. Hvis opgaven er for svær kan du springe den over,
            når den er løst korrekt kan du klikke på 'Ny opgave'. Klik på 'Afslut' når du vl stoppe.</p>
    @endif
    @if(session()->exists('result-set'))

        @if(session()->has('math_error'))
            <div class="alert alert-danger">
                {{ trans('alerts.'.session()->get('math_error')) }}
            </div>
        @endif
        @if(session()->has('math_solution'))
            <div class="alert alert-success">
                {{ trans('alerts.'.session()->get('math_solution')) }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-8">
                @if( ! is_null($text))
                    <p>
                        <i class="fa fa-question-circle"></i> <b>{{ $text }}</b>
                    </p>
                @endif
                $${{ $opg }}$$
                <form>
                    <div class="row">
                        <div class="col-md-4">
                            @foreach($input as $i)
                                <div class="form-group" id="answer-{{ $i->name }}" class="answerArea">
                                    <label class="control-label" for="inputError2">{{ $i->title }}</label>
                                    <input type="text" class="form-control" placeholder="{{ $i->placeholder }}"
                                           name="answer[{{ $i->name }}]" aria-describedby="inputError2Status">
                                    <span class="glyphicon glyphicon-remove form-control-feedback" style="display:none"
                                          id="incorrectIcon-{{ $i->name }}" aria-hidden="true"></span>
                                    <span class="glyphicon glyphicon-ok form-control-feedback" style="display:none"
                                          id="correctIcon-{{ $i->name }}" aria-hidden="true"></span>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <button onclick="validateQuestion()" id="validateBtn" type="button"
                                        class="btn btn-default"
                                        type="submit"><i class="fa fa-check" aria-hidden="true"></i> Tjek Resultat
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <a class="btn btn-danger pull-right" href="{{ route('skip-opgave', [$type, $subtype]) }}"
                               id="skipBtn"><i class="fa fa-forward"></i> Spring Over</a>
                        </div>
                    </div>

                </form>
            </div>
            <div class="col-md-4">
                @if(session()->has('chain'))
                    @include('opgaver.partials.chain')
                @endif
            </div>
        </div>


        <!--<a class="pull-right btn btn-danger">Spring Over</a>-->

    @endif
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/checker.js') }}"></script>
@endsection

@section('js-inject')
    window.Laravel.route = "{{ route("tjek-resultat") }}"
@endsection