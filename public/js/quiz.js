var config = quiz_request.config;
$(document).ready(function() {
    $('button.btn-test').click(function() {
        $('div.btn-test').hide();
        $('div.do-test').show();
        $('li.timer').show();
        $('.form-check-input').show();
        $('.btn-submit').show();
        $('span.btn-refresh').click(function() {
            $('div.btn-test').hide();
            $('div.do-test').show();
            window.location.reload(true);
        });

        // prevent when reload page
        window.onbeforeunload = function() {
            return quiz_request.trans.alert;
        }

        // Timer countdown
        var interval = setInterval(function() {
            var timer = $('li.timer').html();
            timer = timer.split(':');
            var minutes = parseInt(timer[0], parseInt(config.ten));
            var seconds = parseInt(timer[1], parseInt(config.ten));
            seconds--;
            if (minutes < parseInt(config.zero)) {
                return clearInterval(interval);
            }
            if (minutes < parseInt(config.ten)) {
                minutes = '0' + minutes;
            }
            if (seconds < parseInt(config.zero) && minutes != parseInt(config.zero)) {
                minutes--;
                seconds = parseInt(config.fifty_nine);
            } else if (seconds < parseInt(config.ten)) {
                seconds = '0' + seconds;
            }
            $('li.timer').html(minutes + ':' + seconds);
            if (minutes == parseInt(config.zero) && seconds <= parseInt(config.ten)) {
                $('li.timer').css('color', 'red');
                $('li.timer').fadeOut(parseInt(config.fifty));
                $('li.timer').fadeIn(parseInt(config.fifty));
                if (minutes == parseInt(config.zero) && seconds == parseInt(config.zero)) {
                    clearInterval(interval);
                    $.confirm({
                        icon: 'fas fa-warning',
                        type: 'red',
                        title: quiz_request.trans.opps,
                        content: quiz_request.trans.warn_alert,
                        buttons: {
                            ok: function () {
                                $('div#check-all').submit();
                                checkSubmit();
                            },
                        }
                    });
                }
            }
        }, parseInt(config.one_thousand));

        // handle submit
        $('.btn-submit').click(function() {
            window.onbeforeunload = function() {
                return null;
            };
            clearInterval(interval);
            checkSubmit();
        });
    });
});
function checkSubmit() {
    var data = quiz_request.data;
    var topic = quiz_request.topic;
    var dataRequest = {};
    for (i in data) {
        var question_id = data[i].question.id;
        var answers = data[i].answers;
        var answered = [];
        for (j in answers) {
            if ($(`input[name="${answers[j].id}"]`).is(':checked')) {
                var ans = parseInt($(`input[name="${answers[j].id}"]:checked`).val());
                answered.push(ans);
            }
        }
        one_question = {
            'topic' : topic,
            'question_id' : question_id,
            'answered' : answered
        }
        dataRequest[i] = one_question;
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });
    $.ajax({
        url: '/question',
        type: 'GET',
        data : { dataRequest },
        success:function(dataResponse) {
            questionArr = dataResponse.correct;
            if (dataResponse.total >= (questionArr.length * (config.point) * (config.point_sevent))) {
                for (var i = 0; i < questionArr.length; i++) {
                    if (questionArr[i].answer) {
                        for (var j = 0; j < questionArr[i].answered.length; j++) {
                            $(`input[name=${questionArr[i].answered[j]}]`).closest('label').after(`
                                <i class="fas fa-check text-success"></i>
                            `);
                        }
                    } else {
                        for (var j = 0; j < questionArr[i].answered.length; j++) {
                            if (jQuery.inArray(questionArr[i].answered[j], questionArr[i].correct_ans) != config.negative) {
                                $(`input[name=${questionArr[i].answered[j]}]`).closest('label').css({' color' : '#45ba28' }).after(`
                                    <i class="fas fa-check text-success"></i>
                                `);
                            } else {
                                $(`input[name=${questionArr[i].answered[j]}]`).closest('label').after(`
                                    <i class="fas fa-times text-danger"></i>
                                `);
                            }
                        }
                        for (var k = 0; k < questionArr[i].correct_ans.length; k++) {
                            $(`input[name=${questionArr[i].correct_ans[k]}]`).closest('label').css({ 'color' : '#45ba28' });
                        }
                    }
                }
                $('div#score').addClass('alert alert-warning').append(`
                    <span class="alert-link"> `+ quiz_request.trans.score + ` ${dataResponse.score}/${questionArr.length}</span>
                    <span class="alert-link">`+ quiz_request.trans.total + ` ${dataResponse.total}/${questionArr.length * (config.point)} (${((dataResponse.total / (questionArr.length * (config.point))) * (config.hundred)).toFixed(config.two)}%)</span>
                `);
                $('li.explain').show();
            } else {
                $('div#score').addClass('alert alert-warning').append(`
                    <span class="alert-link"> `+ quiz_request.trans.score + `${dataResponse.score}/${questionArr.length}</span>
                    <span class="alert-link">`+ quiz_request.trans.total + `${dataResponse.total}/${questionArr.length * (config.point)} (${((dataResponse.total / (questionArr.length * (config.point))) * (config.hundred)).toFixed(config.two)}%)</span>
                    <span class="alert-link">`+ quiz_request.trans.try_again +`<i class="far fa-smile-wink text-success"></i>
                    </span>
                `);
            }
            $('input').prop('disabled', true);
            $('button.btn-submit').hide();
            $('html, body').animate({
                scrollTop : config.zero,
            });
        }
    });
}
