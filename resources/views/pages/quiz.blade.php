@extends('main')
@section('title', ' Test')
@section('content')
    <div class="form-group quiz">
        @if (!empty($data))
            <div class="form-group">
                <h3 id="title-quiz" >{!! trans('translate.title_topic') !!} {{ $topic->name }}</h3>
                <h3 id="currentQuestionNumberText"> {!! trans('translate.title_question_num', ['count' => count($data)]) !!}
                    <span id="fifteen-min"> ({!! trans('translate.time_clock', ['time' => Config::get('constants.minute')]) !!})</span>
                    {!! Form::button(trans('translate.start_test'), ['class' => 'btn btn-warning', 'id' => 'btn-test']) !!}
                    <a href="#" class="btn btn-default" type="submit" id="btn-refresh">{!! trans('translate.restart_test') !!}</a>
                </h3>
                <hr>
            </div>
            <div class="form-group" id="score"></div>
            <div class="form-group" id="check-all">
                @foreach ($data as $key => $value)
                    <ol class="questions">
                        <li class="alert alert-info title-question">
                            <span class="question-num">{!! trans('translate.number', ['number' => $key + Config::get('constants.number_ques')]) !!}</span>
                            <span id="question">{!! $value['question']->content !!}</span>
                        </li>
                        <ul class="answer">
                            @foreach ($value['answers'] as $key => $answer)
                                <label class="labels">
                                    {!! Form::checkbox($answer->id, $answer->id, null, ['class' => 'answers', 'id' => "$answer->id"]) !!}
                                    <span>({{ $alphabet[$key] }}) {{ $answer->content }} </span>
                                </label>
                            @endforeach
                        </ul>
                    </ol>
                @endforeach
            </div>
        @else
            {!! trans('translate.empty_data') !!}
        @endif
    </div>
@endsection
