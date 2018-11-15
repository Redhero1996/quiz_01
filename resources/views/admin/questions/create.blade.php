@extends('master')
@section('title', '| ' . __('translate.create_question'))
@section('content')
    <div class="card">
        <div class="tab-content">
            <div class="card-body">
                <h3 class="page-title">{{ __('translate.create_question') }}</h3>
                <div class="portlet-body form">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $err)
                                {{ $err }}<br>
                            @endforeach
                        </div>
                    @endif
                    <!-- BEGIN FORM-->
                    {!! Form::open(['method' => 'POST', 'route' => 'questions.store', 'class' => 'form-horizontal']) !!}
                        <div class="form-body">
                            <div class="form-group">
                                {!! Form::label('category_id', __('translate.category'), ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-12">
                                    {!! Form::select('category_id', $categories->pluck('name', 'id'), null, ['class' => 'browser-default custom-select']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('topic_id', __('translate.topic'), ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-12">
                                    {!! Form::select('topic_id', $topics->pluck('name', 'id'), null, ['class' => 'browser-default custom-select']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('content', __('translate.content'), ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-12">
                                    {!! Form::textarea('content', old('content'), ['class' => 'editor']) !!}
                                </div>
                            </div>
                            <div class="form-group ml-3">
                                {!! Form::checkbox('correct_ans[]', config('constants.zero')) !!}
                                <label>{{ __('translate.ans_a') }}</label>
                                {!! Form::text('answer[]', old('answer[0]'), ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group ml-3">
                                {!! Form::checkbox('correct_ans[]', config('constants.one')) !!}
                                <label>{{ __('translate.ans_b') }}</label>
                                {!! Form::text('answer[]', old('answer[1]'), ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group ml-3">
                                {!! Form::checkbox('correct_ans[]', config('constants.two')) !!}
                                <label>{{ __('translate.ans_c') }}</label>
                                {!! Form::text('answer[]', old('answer[2]'), ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group ml-3">
                                {!! Form::checkbox('correct_ans[]', config('constants.three')) !!}
                                <label>{{ __('translate.ans_d') }}</label>
                                {!! Form::text('answer[]', old('answer[3]'), ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group ml-3">
                                {!! Form::label('explain', __('translate.explain')) !!}
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
    {!! Html::script('js/question-create.js') !!}
@stop
