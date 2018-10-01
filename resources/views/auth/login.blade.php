<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	@include('layouts._head')
</head>
<body>
	<!-- Material form login -->
	<div class="card">
        <h5 class="card-header info-color white-text text-center py-4">
            <strong>Sign in</strong>
        </h5>
		<!--Card content-->
		<div class="card-body px-lg-5 pt-0">
		    <!-- Form -->
		    {!! Form::open(['route' => 'login', 'method' => 'POST', 'class' => 'text-center']) !!}
		    <!-- Email -->
		    <div class="md-form mt-5">
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
		    <div class="d-flex justify-content-around">
		        <div>
		            <!-- Remember me -->
		            <div class="form-check">
		            	{!! Form::checkbox('remember', old('remember') ? true : '', ['class' => 'form-check-input', 'id' => 'materialLoginFormRemember']) !!}
		            	{!! Form::label('materialLoginFormRemember', 'Remember me', ['class' => 'form-check-label']) !!}
		            </div>
		        </div>
		        <div>
		            <!-- Forgot password -->
		            <a href="">Forgot password?</a>
		        </div>
		    </div>
		    <!-- Sign in button -->
		    {!! Form::submit('Sign in', ['class' => 'btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0']) !!}
		    <!-- Register -->
		    <p>Not a member?
		        <a href="{{route('register')}}">Register</a>
		    </p>
		    <!-- Social login -->
		    <p>or sign in with:</p>
		    <a type="button" class="btn-floating btn-fb btn-sm">
		       <i class="fab fa-facebook-f"></i>
		    </a>
		    <a type="button" class="btn-floating btn-tw btn-sm">
		        <i class="fas fa-twitter"></i>
		    </a>
		    <a type="button" class="btn-floating btn-li btn-sm">
		        <i class="fas fa-linkedin"></i>
		    </a>
		    <a type="button" class="btn-floating btn-git btn-sm">
		        <i class="fas fa-github"></i>
		    </a>
		    {!! Form::close() !!}
		    <!-- Form -->
		</div>
	</div>
	<!-- Material form login -->
	@include('layouts._script')
</body>
</html>
