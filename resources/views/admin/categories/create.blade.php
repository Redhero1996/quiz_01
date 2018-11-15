@extends('master')
@section('title', '| ' . __('translate.create_category'))
@section('content')
    <div class="card">
        <div class="tab-content">
            <div class="card-body">
                <h3 class="page-title">{{ __('translate.create_category') }}</h3>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    {!! Form::open(['method' => 'POST', 'route' => 'categories.store', 'class' => 'form-horizontal']) !!}
                        <div class="form-body">
                            <div class="form-group last">
                                {!! Form::label('name', 'Name', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-12">
                                    {!! Form::text('name', null, ['class' => 'form-control input-circle', 'placeholder' => 'Enter name']) !!}
                                    @if($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-actions pl-2">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    {!! Form::submit('Submit', ['class' => 'btn btn-info']) !!}
                                    <a href="{{ route('categories.index') }}" class="btn btn-light">
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
