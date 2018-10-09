@extends('main')
@section('title', ' Test')
@section('content')
    <div class="form-group quiz">
        @if (Auth::check())
            @if (!empty($data))
                <div class="form-group">
                    <h3 id="title-quiz" >{!! trans('translate.title_topic') !!} {{ $topic->name }}</h3>
                    <h3 id="currentQuestionNumberText"> {!! trans('translate.title_question_num', ['count' => count($data)]) !!}
                        <span id="fifteen-min"> ({!! trans('translate.time_clock', ['time' => config('constants.minute')]) !!})</span>
                        {!! Form::button(trans('translate.start_test'), ['class' => 'btn btn-warning btn-test']) !!}
                        <a class="btn btn-default btn-refresh" href="{{ route('quiz', [$topic->category->slug, $topic->slug]) }}" id="restart-test">{!! trans('translate.restart_test') !!}</a>
                    </h3>
                    <hr>
                </div>
                <div class="form-group" id="score"></div>
                <div class="form-group" id="check-all">
                    @foreach ($data as $key => $value)
                        <ol class="questions">
                            <li class="alert alert-info title-question">
                                <span class="question-num">{!! trans('translate.number', ['number' => $key + config('constants.number_ques')]) !!} </span>
                                <span id="question"> {!! $value['question']->content !!}</span>
                            </li>
                            <ul class="answer">
                                @foreach ($value['answers'] as $key => $answer)
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            {!! Form::checkbox($answer->id, $answer->id, null, ['class' => 'form-check-input']) !!}
                                            <span class="answers">({{ $alphabet[$key] }}) {{ $answer->content }} </span>
                                        </label>

                                    </div>
                                @endforeach
                            </ul>
                        </ol>
                    @endforeach
                </div>
            @else
                {!! trans('translate.empty_data') !!}
            @endif
        @else
            <div class="form-group text-center">
                {!! trans('translate.permission') !!}
            </div>
        @endif
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        var config = @json(config('constants'));
        $(document).ready(function() {
            $('.btn-test').click(function() {
                $('.btn-test').hide();
                $('.btn-refresh').show();
                $('li.timer').show();
                $('.form-check-input').show();
                $('span#fifteen-min').hide();
                $('.btn-submit').show();

                // prevent when reload page
                window.onbeforeunload = function() {
                    return "{{ trans('translate.alert') }}";
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
                                title: '{{ trans('translate.oops') }}',
                                content: '{{ trans('translate.warn_alert') }}',
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
            var data = @json($data);
            var topic = {{ $topic->id }};
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
                    $('input').prop('disabled', true);
                    $('div#score').addClass('alert alert-warning').append(`
                        <span class="alert-link">{{trans('translate.score')}} ${dataResponse.score}/${questionArr.length}</span>
                        <span class="alert-link">{{trans('translate.total')}} ${dataResponse.total}/${questionArr.length*(config.point)}</span>
                    `);
                    $('button.btn-submit').hide();
                    $('button.btn-refresh').show();
                    $('html, body').animate({
                        scrollTop : config.zero,
                    });
                }
            });
        }
    </script>
@endsection
