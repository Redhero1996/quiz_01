@extends('main')
@section('title', ' Test')
@section('content')
    <div class="form-group quiz">
        @if (!empty($data))
            <div class="form-group">
                <h3 id="title-quiz" >{!! __('translate.title_topic') !!} {{ $topic->name }}</h3>
                <h3 id="currentQuestionNumberText"> {!! __('translate.title_question_num', ['count' => count($data['topic'])]) !!}
                    <a class="btn btn-default btn-refresh review" href="{{ route('quiz', [$topic->category->slug, $topic->slug]) }}" id="restart-test">{!! __('translate.restart_test') !!}</a>
                </h3>
                <hr>
            </div>
            <div class="form-group alert alert-warning" id="score">
                <span class="alert-link">{{ __('translate.score') }} {{ $data['total'] / config('constants.point') }}/{{ count($data['topic']) }}</span>
                <span class="alert-link">{{ __('translate.total')}} {{ $data['total'] }}/{{ count($data['topic']) * config('constants.point') }} ( {{ round(($data['total'] / (count($data['topic']) * config('constants.point'))) * config('constants.hundred'), config('constants.two')) }}% )</span>
                @if ($data['total'] <= (count($data['topic']) * config('constants.point') * config('constants.point_sevent')))
                    <span class="alert-link">{{ __('translate.try_again') }} <i class="far fa-smile-wink text-success"></i>
                    </span>
                @endif
            </div>
            <div class="form-group" id="check-all">
                @foreach ($data['topic'] as $key => $value)
                    <ol class="questions">
                        <li class="alert alert-info title-question">
                            <span class="question-num">{!! __('translate.number', ['number' => $key + config('constants.number_ques')]) !!} </span>
                            <span id="question"> {!! $value['question']->content !!}</span>
                        </li>
                        <ul class="answer">
                            @foreach ($value['answers'] as $ans => $answer)
                                <div class="form-check">
                                    <label class="form-check-label">
                                        @if (isset($value['answered']) && in_array($answer->id, $value['answered']))
                                            {!! Form::checkbox($answer->id, $answer->id, true, ['class' => 'form-check-input answer', 'disabled' => 'disabled']) !!}
                                            <span class="answers">({{ $alphabet[$ans] }}) {{ $answer->content }} </span>
                                        @else
                                            {!! Form::checkbox($answer->id, $answer->id, null, ['class' => 'form-check-input answer', 'disabled' => 'disabled']) !!}
                                            <span class="answers">({{ $alphabet[$ans] }}) {{ $answer->content }} </span>
                                        @endif
                                    </label>
                                </div>
                            @endforeach
                        </ul>
                        <li class="alert alert-secondary explain">
                            <h4 class="font-weight-bold font-italic explain">{{ __('translate.explain') }}</h4>
                            <span class="ml-4">{{ $value['question']->explain }}</span>
                        </li>
                    </ol>
                @endforeach
            </div>
        @endif
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            var config = @json(config('constants'));
            var data = @json($data);
            var topic = data.topic;
            if (data.total >= (topic.length * (config.point) * (config.point_sevent))) {
                $('li.explain').show();
                for (var i = 0; i < topic.length; i++) {
                    if (topic[i].answered && topic[i].answered.length > config.zero ) {
                        for (var j = 0; j < topic[i].answered.length; j++) {
                            if (jQuery.inArray(topic[i].answered[j], topic[i].question.correct_ans) != config.negative) {
                                $(`input[name=${topic[i].answered[j]}]`).closest('label').css({' color' : '#45ba28' }).after(`
                                    <i class="fas fa-check text-success"></i>
                                `);
                            } else {
                                $(`input[name=${topic[i].answered[j]}]`).closest('label').css({' color' : '#45ba28' }).after(`
                                    <i class="fas fa-times text-danger"></i>
                                `);
                            }
                        }
                    } else {
                        for (var k = 0; k < topic[i].question.correct_ans.length; k++) {
                            $(`input[name=${topic[i].question.correct_ans[k]}]`).closest('label').css({ 'color' : '#45ba28' });
                        }
                    }
                }
            }
        });
    </script>
@endsection
