function validateQuestion() {
    $input = $('input[name^=answer]');
    $('#validateBtn').prop("disabled",true);
    $data = {};
    $.each($input, function(index, input){
        $matchAnswer = /answer\[(.*)\]/g;
        $name = $matchAnswer.exec(input.name);
        $.extend($data, {[$name[1]]:input.value});
    });
    $.ajax({
        url: window.Laravel.route,
        method: "POST",
        data: {
            results: $data,
            _token: window.Laravel.csrfToken
        }
    }).done(function (data) {
        var $correct = 0;
        $.each(data, function(index, response){
            $('#answer-' + index).addClass('has-feedback');
            if (response == true) {
                $('#answer-' + index).addClass('has-success');
                $('#answer-' + index).removeClass('has-error');
                $('#incorrectIcon-' + index).hide();
                $('#correctIcon-' + index).show();
                $correct++;
            } else {
                $('#answer-' + index).removeClass('has-success');
                $('#answer-' + index).addClass('has-error');
                $('#incorrectIcon-' + index).show();
                $('#correctIcon-' + index).hide();
            }
        });
        if ($correct == Object.keys(data).length) {
            $('#skipBtn').text('Næste Spørgsmål');
            $('#skipBtn').removeClass('btn-danger');
            $('#skipBtn').addClass('btn-success');
        }
        /*$('#answerArea').addClass('has-feedback');
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
        }*/
    }).always(function(){
        $('#validateBtn').prop("disabled",false);
    });
}