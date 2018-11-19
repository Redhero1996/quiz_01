@extends('main')
@section('title', '| ' . __('translate.topic'))
@section('content')
    <div class="form-group quiz">
        <div class="form-group">
            <h3 id="title-quiz">{!! __('translate.topic') !!} </h3>
            @if (Session::has('success'))
                <div class="portlet-title" id="message">
                    <div class="alert alert-success">
                        {!! Session::get('success') !!}
                    </div>
                </div>
            @endif
            <div class="form-body">
                <div class="form-group">
                    {!! Form::label('category_id', __('translate.category'), ['class' => 'col-md-3 control-label']) !!}
                    <div class="col-md-12">
                        {!! Form::text('category_id', $category->name, ['class' => 'form-control input-circle', 'disabled' => 'disabled']) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('topic_id', __('translate.topic'), ['class' => 'col-md-3 control-label']) !!}
                    <div class="col-md-12">
                        {!! Form::text('topic_name', $topic->name, ['class' => 'form-control input-circle', 'disabled' => 'disabled']) !!}
                    </div>
                </div>
                <div class="form-body question-form">
                    @foreach ($questions as $k => $question)
                        <div class="form-group">
                            <label for="question" class="ml-3 question">{!! __('translate.question'). ' ' . $k+=1 !!}: </label>
                            <span class="content">{!! strip_tags(htmlspecialchars_decode($question->content)) !!}</span>
                        </div>
                        @foreach ($question->answers as $key => $answer)
                            <div class="form-group ml-4">
                                {!! Form::checkbox('correct_ans', $answer->id, in_array($answer->id, $question->correct_ans) ?? true, ['disabled' => 'disabled']) !!}
                                <label>{{ $alphabet[$key] }}.</label>
                                <span>{!! $answer->content !!}</span>
                            </div>
                        @endforeach
                    <div class="form-group ml-3">
                        <label for="explain"><i>{{ __('translate.explain') }}:</i> </label>
                        <span>
                            @if (!empty($question->explain))
                                {!! strip_tags(htmlspecialchars_decode($question->explain)) !!}
                            @else
                                {{ __('translate.no_explain') }}
                            @endif    
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="form-actions pl-2">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        @if ($topic->status == 0)
                            <a href="{{ route('create-topics.edit', $topic->id) }}" class="btn btn-warning edit">{{ __('translate.edit') }}</a>
                        @endif
                        <a href="{{ route('create-topics.index', Auth::user()->id) }}" class="btn btn-light submit">
                            {{ __('translate.return') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#message').fadeTo(2000, 500).slideUp(500, function(){
                $('#message').slideUp(500);
            });
        });
    </script>
@endsection
