<nav class="mb-1 navbar navbar-expand-lg navbar-dark special-color-dark fixed-top">
    <a class="navbar-brand quiz" href="{{ url('/') }}">QUIZ</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-3"
    aria-controls="navbarSupportedContent-3" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent-3">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item homepage {{ Request::is('/') ? 'active' : "" }}">
                <a class="nav-link" href="{{ url('/') }}">{{ trans('translate.homepage') }}
                    <span class="sr-only">(current)</span>
                </a>
            </li>
            <li class="nav-item about {{ Request::is('about') ? 'active' : "" }}">
                <a class="nav-link" href="{{ url('about') }}">{{ trans('translate.about') }}</a>
            </li>
            <li class="nav-item contact {{ Request::is('contact') ? 'active' : "" }}">
                <a class="nav-link" href="{{ url('contact') }}">{{ trans('translate.contact') }}</a>
            </li>
        </ul>
        <ul class="nav navbar-nav test">
            <li class="nav-item timer">{{ config('constants.minute') }}:{{ config('constants.second') }}</li>
            <li class="nav-item">
                {!! Form::button(trans('translate.submit'), ['type' => 'submit', 'class' => 'btn btn-primary btn-submit']) !!}
            </li>
        </ul>
        <ul class="navbar-nav ml-auto nav-flex-icons">
            @if(Auth::check())
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="avatar" src="#"> {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-default ml-5" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#"><i class="fas fa-user"></i> {{ trans('translate.account') }}</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i> {{ trans('translate.logout') }}</a>
                    </div>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link btn-login" href="{{ route('login') }}">{{ trans('translate.login') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ trans('translate.register') }}</a>
                </li>
            @endif
        </ul>
    </div>
</nav>
