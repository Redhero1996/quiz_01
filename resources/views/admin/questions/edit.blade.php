@extends('master')
@section('title', '| ' . __('translate.edit_question'))
@section('content')
    <div class="card">
        <div class="tab-content">
            <div class="card-body">
                <h3 class="page-title">{{ __('translate.edit_question') }}</h3>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    {!! Form::model($question, ['method' => 'PUT', 'route' => ['questions.update', $question->id], 'class' => 'form-horizontal']) !!}
                        <div class="form-body">
                            <div class="form-group">
                                {!! Form::label('category_id', __('translate.category'), ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-12">
                                    {!! Form::select('category_id', $categories->pluck('name', 'id'), $category, ['class' => 'browser-default custom-select']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('topic_id', __('translate.topic'), ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-12">
                                    {!! Form::select('topic_id', $question->topics->pluck('name', 'id'), $topic_name, ['class' => 'browser-default custom-select']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('content', __('translate.content'), ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-12">
                                    {!! Form::textarea('content', old('content'), ['class' => 'editor']) !!}
                                    @if($errors->has('content'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('content') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @foreach ($answers as $key => $answer)
                                <div class="form-group ml-3">
                                    @if(in_array($answer->id, $question->correct_ans))
                                        {!! Form::checkbox('correct_ans[]', $answer->id, true) !!}
                                    @else
                                        {!! Form::checkbox('correct_ans[]', $answer->id) !!}
                                    @endif
                                        <label>{{ __('translate.ans') }} {{$alphabet[$key]}}:</label>
                                        {!! Form::text('answer[]', $answer->content, ['class' => 'form-control']) !!}
                                </div>
                            @endforeach
                            <div class="form-group ml-3">
                                {!! Form::label('explain', __('translate.content')) !!}
                                <div class="col-md-12">
                                    {!! Form::textarea('explain', old('explain'), ['class' => 'editor']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-actions pl-2">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    {!! Form::submit('Submit', ['class' => 'btn btn-info']) !!}
                                    <a href="{{ route('questions.index') }}" class="btn btn-light">
                                        {{ __('translate.cancel') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                    <!-- END FORM-->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $('select[name="category_id"]').on('click', function() {
            var category_id = $(this).val();
            $.ajax({
                url: '/admin/select-ajax/' + category_id,
                type: 'GET',
                dataType: 'json',
                success:function(data) {
                    $('select[name="topic_id"]').empty();
                    $.each(data, function(key, topic) {
                        $('select[name="topic_id"]').append(
                        "<option value='" + topic.id + "'>" + topic.name + "</option>"
                    );
                  });
                }
            });
        });
    </script>
@stop
