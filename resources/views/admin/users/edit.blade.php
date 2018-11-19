@extends('master')
@section('title', '| ' . __('translate.edit_user'))
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h2 class="page-header">{{ __('translate.edit_user') }}</h2>
                </div>
                <!-- /.col-lg-12 -->
                {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'PUT']) !!}
                    <div class="col-md-8 col-md-offset-2">                 
                        <div class="form-group">
                            <label>{{ __('translate.avatar') }}</label><br>
                            @if ($user->avatar == null )
                                <img id="img" class="avatar profile" src="{{ config('view.image_paths.images') . 'avatar-default-icon.png' }}" />
                            @else
                                <img id="img" class="avatar profile" src="{{ config('view.image_paths.images') . $user->avatar }}" />
                            @endif
                            {!! Form::file('avatar', ['id' => 'upload']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('name', __('translate.username')) !!}
                            {!! Form::text('name', $user->name, ['class' => 'form-control']) !!}
                            @if ($errors->has('name'))
                                <p class="help-block validated" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </p>
                            @endif
                        </div>
                        <div class="form-group">
                            {!! Form::label('first_name', __('translate.first_name')) !!}
                            {!! Form::text('first_name', $user->first_name, ['class' => 'form-control']) !!}
                            @if ($errors->has('first_name'))
                                <p class="help-block validated" role="alert">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </p>
                            @endif
                        </div>
                        <div class="form-group">
                            {!! Form::label('last_name', __('translate.last_name')) !!}
                            {!! Form::text('last_name', $user->last_name, ['class' => 'form-control']) !!}
                            @if ($errors->has('last_name'))
                                <p class="help-block validated" role="alert">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </p>
                            @endif
                        </div>
                        <div class="form-group">
                            {!! Form::label('phone_number', __('translate.phone_number')) !!}
                            {!! Form::text('phone_number', $user->phone_number, ['class' => 'form-control']) !!}
                            @if ($errors->has('phone_number'))
                                <p class="help-block validated" role="alert">
                                    <strong>{{ $errors->first('phone_number') }}</strong>
                                </p>
                            @endif
                        </div>
                        <div class="form-group">
                            {!! Form::label('address', __('translate.address')) !!}
                            {!! Form::text('address', $user->address, ['class' => 'form-control']) !!}
                            @if ($errors->has('address'))
                                <p class="help-block validated" role="alert">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </p>
                            @endif
                        </div>
                        <div class="form-group">
                            {!! Form::label('email', 'E-mail') !!}
                            {!! Form::email('email', $user->email, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                            @if ($errors->has('email'))
                                <p class="help-block validated" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </p>
                            @endif
                        </div>
                        <div class="form-group">
                            {!! Form::checkbox('change_password', null, null, ['id' => 'change_password']) !!}
                            {!! Form::label('change_password', __('translate.change_password')) !!}
                            {!! Form::label('password', __('translate.password')) !!}
                            {!! Form::password('password', ['class' => 'form-control password', 'disabled' => 'disabled']) !!}
                            @if ($errors->has('password'))
                                <p class="help-block validated" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </p>
                            @endif
                        </div> 
                        <div class="form-group">
                            {!! Form::label('password_confirmation', __('translate.confirm_password')) !!}
                            {!! Form::password('password_confirmation', ['class' => 'form-control password', 'disabled' => 'disabled']) !!}
                        </div> 
                        <div class="form-group">
                            {!! Form::label('role', __('translate.role')) !!}
                            {!! Form::radio('role_id', 1, $user->role_id == 1 ? true : null, ['class' => 'mr-2']) !!}{{ __('translate.admin') }}
                            {!! Form::radio('role_id', 2, $user->role_id == 2 ? true : null, ['class' => 'ml-5 mr-2']) !!}{{ __('translate.user') }}
                        </div>                     
                        <div class="row">
                            <div class="col-sm-6">
                                {!! Form::submit('Submit', ['class' => 'btn btn-info']) !!}
                            </div>
                            <div class="col-sm-6">      
                                <a href="{{route('users.show', $user->id)}}" class="btn btn-danger btn-block">{{ __('translate.cancel') }}</a>
                            </div>
                        </div><br>                       
                    </div>
                {!! Form::close() !!}
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        // Check password
        $(document).ready(function() {
            $('input#change_password').change(function() {
                if ($(this).is(':checked')) {
                    $('.password').removeAttr('disabled');
                } else {
                    $('.password').attr('disabled', '');
                }
            });
        });
        // Avatar
        $(document).ready(function () {
            $('#upload').change( function () {
                $('#img').show();
                var input = this;
                var url = $(this).val();
                var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
                if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"))
                {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                       $('#img').attr('src', e.target.result);
                       $('#img').css({"width" : "200px", "height" : "200px"});

                    }
                    reader.readAsDataURL(input.files[0]);
                }
                else
                {
                    $('#img').attr('src', avatar.avatar);
                }
            });
        });
    </script>
@stop
