<!DOCTYPE html>
<html lang="en">
<head>
	<title>Register</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	@include('layouts._head')
</head>
<body>
    <!-- Material form register -->
    <div class="card">
        <h5 class="card-header info-color white-text text-center py-4">
            <strong>Sign up</strong>
        </h5>
        <!--Card content-->
        <div class="card-body px-lg-5 pt-0">
            <!-- Form -->
            {!! Form::open(['route' => 'register', 'method' => 'POST', 'class' => 'text-center']) !!}
                <div class="md-form mt-5">
                    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'materialRegisterFormName']) !!}
                    {!! Form::label('materialRegisterFormName', 'Username') !!}
                    @if($errors->has('name'))
                        <span class="help-block" style="color: red;">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                <!-- E-mail -->
                <div class="md-form mt-0">
                    {!! Form::email('email', null, ['class' => 'form-control', 'id' => 'materialRegisterFormEmail']) !!}
                    {!! Form::label('materialRegisterFormEmail', 'E-mail') !!}
                    @if($errors->has('email'))
                        <span class="help-block" style="color: red;">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <!-- Password -->
                <div class="md-form">
                    {!! Form::password('password', ['class' => 'form-control', 'id' => 'materialRegisterFormPassword', 'aria-describedby' => 'materialRegisterFormPasswordHelpBlock']) !!}
                    {!! Form::label('materialRegisterFormPassword', 'Password') !!}
                    @if($errors->has('password'))
                        <span class="help-block" style="color: red;">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                 <div class="md-form">
                    {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'materialRegisterFormPassword', 'aria-describedby' => 'materialRegisterFormPasswordHelpBlock']) !!}
                    {!! Form::label('materialRegisterFormPassword', 'Confirm Password') !!}
                </div>
                <!-- Sign up button -->
                {!! Form::submit('Sign up', ['class' => 'btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0']) !!}
                <!-- Social register -->
                <p>or sign up with:</p>
                <a type="button" class="btn-floating btn-fb btn-sm">
                    <i class="fa fa-facebook"></i>
                </a>
                <a type="button" class="btn-floating btn-tw btn-sm">
                    <i class="fa fa-twitter"></i>
                </a>
                <a type="button" class="btn-floating btn-li btn-sm">
                    <i class="fa fa-linkedin"></i>
                </a>
                <a type="button" class="btn-floating btn-git btn-sm">
                    <i class="fa fa-github"></i>
                </a>
                <hr>
            {!! Form::close() !!}
            <!-- Form -->
          </div>
    </div>
    <!-- Material form register -->
    @include('layouts._script')
</body>
</html>
