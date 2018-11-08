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
                            <li class="alert alert-secondary explain">
                                <h4 class="font-weight-bold font-italic explain">{{ trans('translate.explain') }}</h4>
                                <span class="ml-4">{{ $value['question']->explain }}</span>
                            </li>
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
    <script>
        var quiz_request = {
            config: @json(config('constants')),
            data : @json($data),
            topic : {!! $topic->id !!},
            trans: {
                alert: '{{ __('translate.alert') }}',
                opps: '{{ __('translate.oops') }}',
                warn_alert: '{{ __('translate.warn_alert') }}',
                score: '{{ __('translate.score') }}',
                total: '{{ __('translate.total') }}',
                try_again: '{{ __('translate.try_again') }}',
            }
        }
        var token = '{{ Session::token() }}';
    </script>
    {!! Html::script('js/quiz.js') !!}
@endsection
