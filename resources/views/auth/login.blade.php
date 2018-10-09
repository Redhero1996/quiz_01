<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ trans('translate.login') }}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('layouts._head')
</head>
<body>
    <div class="container-fluid login">
        <!-- Default form login -->
        {!! Form::open(['route' => 'login', 'method' => 'POST', 'class' => 'text-center border border-light p-5']) !!}
            <p class="h4 mb-4">{{ trans('translate.login') }}</p>
            <!-- Email -->
            {!! Form::email('email', null, ['class' => 'form-control email', 'id' => 'defaultLoginFormEmail', 'placeholder' => 'E-mail']) !!}
            @if ($errors->has('email'))
                <p class="help-block validated" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </p>
            @endif
            <!-- Password -->
            {!! Form::password('password', ['class' => 'form-control mt-4 password', 'id' => 'defaultLoginFormPassword', 'placeholder' => trans('translate.password')]) !!}
            @if ($errors->has('password'))
                <p class="help-block validated" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </p>
            @endif
            <div class="d-flex justify-content-around mt-4">
                <div>
                    <!-- Remember me -->
                    <div class="custom-control custom-checkbox">
                        {!! Form::checkbox('remember', null, old('remember') ? true : '', ['class' => 'custom-control-input', 'id' => 'defaultLoginFormRemember']) !!}
                        {!! Form::label('defaultLoginFormRemember', trans('translate.remember'), ['class' => 'custom-control-label']) !!}
                    </div>
                </div>
                <div>
                    <!-- Forgot password -->
                    <a href="{{ route('password.request') }}">{{ trans('translate.forget_pass') }}</a>
                </div>
            </div>
            <!-- Sign in button -->
            {!! Form::button(trans('translate.login'), ['type' => 'submit', 'class' => 'btn btn-info btn-block my-4 login']) !!}
            <!-- Register -->
            <p>{{ trans('translate.not') }}
                <a href="{{ route('register') }}">{{ trans('translate.register') }}</a>
            </p>
            <!-- Social login -->
            <p>{{ trans('translate.login_social') }}</p>

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
        <!-- Default form login -->
    </div>
    @include('layouts._script')
</body>
</html>
