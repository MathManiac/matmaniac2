@extends('opgaver.master')

@section('opgaveContent')
    <!--<h1>{{ trans('tasks.subExercises.'.$subtype->name) }}</h1>-->
    @include('opgaver.partials.status-bar', compact('type', 'subtype'))
    <p>Klik på 'Ny opgave' når du vil i gang. Hvis opgaven er for svær kan du springe den over,
        når den er løst korrekt kommer der automatisk en ny opgave. Klik på 'Afslut' når du vl stoppe.</p>
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

        $${{ $opg }}$$


        <!--<a class="pull-right btn btn-danger">Spring Over</a>-->
        <form>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group" id="answerArea">
                        <label class="control-label" for="inputError2">Dit Svar</label>
                        <input type="text" class="form-control" id="result" aria-describedby="inputError2Status">
                        <span class="glyphicon glyphicon-remove form-control-feedback" style="display:none" id="incorrectIcon" aria-hidden="true"></span>
                        <span class="glyphicon glyphicon-ok form-control-feedback" style="display:none" id="correctIcon" aria-hidden="true"></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <button onclick="validateQuestion()" id="validateBtn" type="button" class="btn btn-default"
                                type="submit"><i class="fa fa-check" aria-hidden="true"></i> Tjek Resultat
                        </button>
                    </div>
                </div>
                <div class="col-md-4">
                    <a class="btn btn-danger pull-right" href="{{ route('skip-opgave', [$type, $subtype]) }}" id="skipBtn">Spring Over</a>
                </div>
            </div>
        </form>

        <script type="text/javascript">
            function validateQuestion() {
                $('#validateBtn').prop("disabled",true);
                $.ajax({
                    url: "{{ route("tjek-resultat") }}",
                    method: "POST",
                    data: {
                        result: $('#result').val(),
                        _token: "{{ csrf_token() }}"
                    }
                }).done(function (data) {
                    $('#answerArea').addClass('has-feedback');
                    if (data.response == true) {
                        $('#answerArea').addClass('has-success');
                        $('#answerArea').removeClass('has-error');
                        $('#incorrectIcon').hide();
                        $('#correctIcon').show();
                        $('#validateBtn').remove();
                        $('#skipBtn').text('Næste Spørgsmål');
                        $('#skipBtn').removeClass('btn-danger');
                        $('#skipBtn').addClass('btn-success');

                    }
                    else {
                        $('#answerArea').addClass('has-error');
                        $('#answerArea').removeClass('has-success');
                        $('#incorrectIcon').show();
                        $('#correctIcon').hide();
                    }
                }).always(function(){
                    $('#validateBtn').prop("disabled",false);
                });
            }
        </script>
    @endif
@endsection