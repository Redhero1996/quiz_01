@extends('main')
@section('title', '| ' . __('translate.create_topic'))
@section('content')
    <div class="form-group quiz">
        <div class="form-group">
            <h3 id="title-quiz">{!! __('translate.create_topic') !!} </h3>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $err)
                        {{ $err }}<br>
                    @endforeach
                </div>
            @endif
            @if (Session::has('success'))
                <div class="portlet-title" id="message">
                    <div class="alert alert-success">
                        {!! Session::get('success') !!}
                    </div>
                </div>
            @endif
            {!! Form::open(['route' => ['create-topics.update', $topic->id], 'method' => 'PUT', 'class' => 'form-horizontal created']) !!}
                <div class="form-body">
                    <div class="form-group">
                        {!! Form::label('category_id', __('translate.category'), ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-12">
                            {!! Form::select('category_id', $categories->pluck('name', 'id'), $topic->category_id, ['class' => 'browser-default custom-select']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('topic_id', __('translate.topic'), ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-12">
                            {!! Form::text('topic_name', $topic->name, ['class' => 'form-control input-circle', 'placeholder' => 'Enter name of topic']) !!}
                            @if($errors->has('topic_name'))
                                <span class="help-block" style="color: red;">
                                    <strong>{{ $errors->first('topic_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-body question-form">
                        @foreach ($questions as $k => $question)
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span>
                            </button>
                            <div class="form-group">
                                <label for="question" class="col-md-3 control-label question">{!! __('translate.question'). ' ' . $k+=1 !!}</label>
                                <div class="col-md-12">
                                    {!! Form::textarea("content[$question->id]", $question->content, ['class' => 'editor']) !!}
                                    @if($errors->has('content'))
                                        <span class="help-block" style="color: red;">
                                            <strong>{{ $errors->first('content') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @foreach ($question->answers as $key => $answer)
                                <div class="form-group ml-4">
                                    {!! Form::checkbox("correct_ans[$question->id][]", $answer->id, in_array($answer->id, $question->correct_ans) ?? true) !!}
                                    <label>{{ __('translate.answer'). ' ' .$alphabet[$key] }}</label>
                                    {!! Form::text("answer[$question->id][]", $answer->content, ['class' => 'form-control']) !!}
                                </div>
                            @endforeach
                            <div class="form-group ml-3">
                            <label for="explain"><i>{{ __('translate.explain') }}:</i> </label>
                            <div class="col-md-12">
                                {!! Form::textarea("explain[$question->id][]", $question->explain, ['class' => 'editor']) !!}
                            </div>
                            </div>  
                        </div>    
                        @endforeach
                    </div>
                </div>
                <div class="form-actions pl-2">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            {!! Form::submit(__('translate.edit'), ['class' => 'btn btn-info']) !!}
                            <a href="{{ route('create-topics.index', Auth::user()->id) }}" class="btn btn-light submit">
                                {{ __('translate.cancel') }}
                            </a>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
@section('scripts')
    {!! Html::script('bower_components/ckeditor5-build-classic/build/ckeditor.js') !!}
    <script type="text/javascript">
        var allEditors = document.querySelectorAll('.editor');
        for (var i = 0; i < allEditors.length; ++i) {
          ClassicEditor.create(allEditors[i]);
        }
        $(document).ready(function() {
            var number_quest = {!! count($questions) !!}
            $('#message').fadeTo(2000, 500).slideUp(500, function(){
                $('#message').slideUp(500);
            });
        });
    </script>
@endsection
