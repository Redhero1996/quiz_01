<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ trans('translate.title', ['title' => 'Đăng ký']) }}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('layouts._head')
</head>
<body>
    <div class="container-fluid register">
        <!-- Default form register -->
        {!! Form::open(['route' => 'register', 'method' => 'POST', 'class' => 'text-center border border-light p-5']) !!}
            <p class="h4 mb-4">{{ trans('translate.title', ['title' => 'ĐĂNG KÝ']) }}</p>
            {!! Form::text('name', null, ['class' => 'form-control username', 'id' => 'defaultRegisterFormFirstName', 'placeholder' => trans('translate.username')]) !!}
            @if ($errors->has('name'))
                <p class="help-block validated" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </p>
            @endif
            <!-- E-mail -->
            {!! Form::email('email', null, ['class' => 'form-control mt-4 email', 'id' => 'defaultRegisterFormEmail', 'placeholder' => 'E-mail']) !!}
            @if ($errors->has('email'))
                <p class="help-block validated" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </p>
            @endif
            <!-- Password -->
            {!! Form::password('password', ['class' => 'form-control mt-4 password', 'id' => 'defaultRegisterFormPassword', 'aria-describedby' => 'defaultRegisterFormPasswordHelpBlock', 'placeholder' => trans('translate.password')]) !!}
            @if ($errors->has('password'))
                <p class="help-block validated" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </p>
            @endif
            {!! Form::password('password_confirmation', ['class' => 'form-control mt-4 password-confirm', 'id' => 'defaultRegisterFormConfirmPassword', 'aria-describedby' => 'defaultRegisterFormPasswordHelpBlock', 'placeholder' => trans('translate.confirm_password')]) !!}
            <!-- Sign up button -->
            {!! Form::button(trans('translate.title', ['title' => 'Đăng ký']), ['type' => 'submit', 'class' => 'btn btn-info my-4 btn-block register']) !!}
            <!-- Register -->
            <p>{{ trans('translate.warning', ['warn' => 'đã']) }}
                <a href="{{ route('login') }}">{{ trans('translate.title', ['title' => 'Đăng nhập']) }}</a>
            </p>
            <!-- Social register -->
            <p>{{ trans('translate.social', ['title' => 'đăng ký']) }}</p>
            <a class="light-blue-text mx-2">
                <i class="fab fa-facebook"></i>
            </a>
            <a class="light-blue-text mx-2">
                <i class="fab fa-twitter"></i>
            </a>
            <a class="light-blue-text mx-2">
                <i class="fab fa-linkedin"></i>
            </a>
            <a class="light-blue-text mx-2">
                <i class="fab fa-github"></i>
            </a>
        {!! Form::close() !!}
        <!-- Default form register -->
    </div>
    @include('layouts._script')
</body>
</html>
