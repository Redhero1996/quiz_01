@extends('main')
@section('title', ' Test')
@section('content')
    <div class="form-group quiz">
        @if (!empty($data))
            <div class="form-group">
                <h3 id="title-quiz" >{!! trans('translate.title_topic') !!} {{ $topic->name }}</h3>
                <h3 id="currentQuestionNumberText"> {!! trans('translate.title_question_num', ['count' => count($data['topic'])]) !!}
                    <a class="btn btn-default btn-refresh review" href="{{ route('quiz', [$topic->category->slug, $topic->slug]) }}" id="restart-test">{!! trans('translate.restart_test') !!}</a>
                </h3>
                <hr>
            </div>
            <div class="form-group alert alert-warning" id="score">
                <span class="alert-link">{{trans('translate.score')}} {{ $data['total'] / config('constants.point') }}/{{ count($data['topic']) }}</span>
                <span class="alert-link">{{trans('translate.total')}} {{ $data['total'] }}/{{ count($data['topic'])*config('constants.point') }}</span>
            </div>
            <div class="form-group" id="check-all">
                @foreach ($data['topic'] as $key => $value)
                    <ol class="questions">
                        <li class="alert alert-info title-question">
                            <span class="question-num">{!! trans('translate.number', ['number' => $key + config('constants.number_ques')]) !!} </span>
                            <span id="question"> {!! $value['question']->content !!}</span>
                        </li>
                        <ul class="answer">
                            @foreach ($value['answers'] as $ans => $answer)
                                <div class="form-check">
                                    <label class="form-check-label">
                                        @if (isset($value['answered']) && in_array($answer->id, $value['answered']))
                                            {!! Form::checkbox($answer->id, $answer->id, true, ['class' => 'form-check-input answer', 'disabled' => 'disabled']) !!}
                                            <span class="answers">({{$alphabet[$ans]}}) {{ $answer->content }} </span>
                                        @else
                                            {!! Form::checkbox($answer->id, $answer->id, null, ['class' => 'form-check-input answer', 'disabled' => 'disabled']) !!}
                                            <span class="answers">({{$alphabet[$ans]}}) {{ $answer->content }} </span>
                                        @endif
                                    </label>
                                </div>
                            @endforeach
                        </ul>
                    </ol>
                @endforeach
            </div>
        @endif
    </div>
@endsection
