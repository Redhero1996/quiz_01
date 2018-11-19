@extends('master')
@section('title', '| ' . __('translate.create_user'))
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h1 class="page-header">{{ __('translate.create_user') }}</h1>
                </div>
                <!-- /.col-lg-12 -->
                <div class="col-md-8 col-md-offset-2 user">                   
                    <!-- FORM-->
                    {!! Form::open(['route' => 'users.store', 'method' => 'POST', 'files' => true]) !!}
                        <div class="form-group">
                            {!! Form::label('avatar', __('translate.avatar')) !!}<br>
                            <img src="" id="img" class="image-avatar">
                            {!! Form::file('avatar', ['id' => 'upload']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('username', __('translate.username')) !!}
                            {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => __('translate.username')]) !!}
                            @if ($errors->has('name'))
                                <p class="help-block validated" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </p>
                            @endif
                        </div>
                        <div class="form-group">
                            {!! Form::label('first_name', __('translate.first_name')) !!}
                            {!! Form::text('first_name', old('first_name'), ['class' => 'form-control', 'placeholder' => __('translate.first_name')]) !!}
                            @if ($errors->has('first_name'))
                                <p class="help-block validated" role="alert">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </p>
                            @endif
                        </div>
                        <div class="form-group">
                            {!! Form::label('last_name', __('translate.last_name')) !!}
                            {!! Form::text('last_name', old('last_name'), ['class' => 'form-control', 'placeholder' => __('translate.last_name')]) !!}
                            @if ($errors->has('last_name'))
                                <p class="help-block validated" role="alert">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </p>
                            @endif
                        </div>
                        <div class="form-group">
                            {!! Form::label('phone_number', __('translate.phone_number')) !!}
                            {!! Form::text('phone_number', old('phone_number'), ['class' => 'form-control', 'placeholder' => __('translate.phone_number')]) !!}
                            @if ($errors->has('phone_number'))
                                <p class="help-block validated" role="alert">
                                    <strong>{{ $errors->first('phone_number') }}</strong>
                                </p>
                            @endif
                        </div>
                        <div class="form-group">
                            {!! Form::label('address', __('translate.address')) !!}
                            {!! Form::text('address', old('address'), ['class' => 'form-control', 'placeholder' => __('translate.address')]) !!}
                            @if ($errors->has('address'))
                                <p class="help-block validated" role="alert">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </p>
                            @endif
                        </div>
                        <div class="form-group">
                            {!! Form::label('email', 'E-mail') !!}
                            {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => 'email']) !!}
                            @if ($errors->has('email'))
                                <p class="help-block validated" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </p>
                            @endif
                        </div>
                       <div class="form-group">
                            {!! Form::label('password', __('translate.password')) !!}
                            {!! Form::password('password', ['class' => 'form-control password', 'placeholder' => __('translate.password')]) !!}
                            @if ($errors->has('password'))
                                <p class="help-block validated" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </p>
                            @endif
                        </div> 
                        <div class="form-group">
                            {!! Form::label('password_confirmation', __('translate.confirm_password')) !!}
                            {!! Form::password('password_confirmation', ['class' => 'form-control password', 'placeholder' => __('translate.confirm_password')]) !!}
                        </div> 
                        <div class="form-group">
                            {!! Form::label('role', __('translate.role')) !!}
                            <div class="custom-control custom-radio">
                                {!! Form::radio('role', 1, null, ['class' => 'mr-2']) !!} {{ __('translate.admin') }}
                                {!! Form::radio('role', 2, true, ['class' => 'ml-5 mr-2']) !!} {{ __('translate.user') }}
                            </div>
                        </div>
                       <div class="row">     
                            {!! Form::submit(__('translate.save'), ['class' => 'btn btn-info']) !!}
                            <a href="{{ route('users.index') }}" class="btn btn-light">
                                {{ __('translate.cancel') }}
                            </a>                           
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        // Avatar
        $(document).ready(function () {
            $('#upload').change( function () {
                $('#img').show();
                var input = this;
                var url = $(this).val();
                var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
                if (input.files && input.files[0] && (ext == 'gif' || ext == 'png' || ext == 'jpeg' || ext == 'jpg'))
                {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                       $('#img').attr('src', e.target.result);
                       $('#img').css({'width' : '200px', 'height' : '200px'});

                    }
                   reader.readAsDataURL(input.files[0]);
                }
                else
                {
                  $('#img').attr('src', $(this).attr('src'));
                }
            });
        });
    </script>
@stop
