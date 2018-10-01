<nav class="mb-1 navbar navbar-expand-lg navbar-dark special-color-dark fixed-top">
    <a class="navbar-brand" href="/">QUIZ</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-3"
    aria-controls="navbarSupportedContent-3" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent-3">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item {{ Request::is('/') ? 'active' : "" }}">
                <a class="nav-link" href="/">Trang chủ
                    <span class="sr-only">(current)</span>
                </a>
            </li>
            <li class="nav-item {{ Request::is('about') ? 'active' : "" }}">
                <a class="nav-link" href="/about">Về chúng tôi</a>
            </li>
            <li class="nav-item {{ Request::is('contact') ? 'active' : "" }}">
                <a class="nav-link" href="/contact">Liên hệ</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto nav-flex-icons">
            @if(Auth::check())
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user"></i> {{Auth::user()->name}}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-default" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">Tài khoản</a>
                        <a class="dropdown-item" href="{{route('logout')}}">Đăng xuất</a>
                    </div>
                </li>
            @else 
                <li class="nav-item">
                    <a class="nav-link" href="{{route('login')}}">ĐĂNG NHẬP</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('register')}}">ĐĂNG KÝ</a>
                </li>
            @endif  
        </ul>
    </div>
</nav>
