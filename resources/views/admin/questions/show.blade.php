@extends('master')
@section('title', '| ' . __('translate.detail_question'))
@section('content')
    <div class="card">
        <div class="tab-content">
            <div class="card-body">
                <h3 class="page-title">{{ __('translate.detail_question') }}</h3>
                <div class="portlet-body form">
                    <div class="form-body">
                        <div class="form-group">
                            {!! Form::label('category', __('translate.category'), ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-12">
                                {!! Form::text('category', $category, ['class' => 'form-control input-circle', 'disabled' => 'disabled']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('topic', __('translate.topic'), ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-12">
                                {!! Form::text('topic', $topic_name, ['class' => 'form-control input-circle', 'disabled' => 'disabled']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('question', __('translate.question'), ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-12 ml-3">
                                <strong><i><p>{!! $question->content !!}</p></i></strong>
                            </div>
                        </div>
                        @foreach ($answers as $key => $answer)
                            <div class="form-group ml-5">
                                <span><strong>{{ $alphabet[$key] }}.</strong></span>
                                <p class="answer"> {{ $answer->content }}</p>
                            </div>
                        @endforeach
                        <div class="form-group ml-5">
                            <label for="correct" class="correct_ans">{{ __('translate.correct_ans') }}: </label>
                            @foreach ($answers as $key => $answer)
                                @foreach ($question->correct_ans as $correct)
                                    @if ($answer->id == $correct)
                                        <span><i><strong>{{$alphabet[$key]}}</strong></i></span>
                                    @endif
                                @endforeach
                            @endforeach
                         </div>
                        <div class="form-group">
                            {!! Form::label('explain', __('translate.explain'), ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-12 ml-3">
                                {!! $question->explain !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-actions pl-2">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-warning">
                                    {{ __('translate.edit') }}
                                </a>
                                <a href="{{ route('questions.index') }}" class="btn btn-light">
                                    {{ __('translate.cancel') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
