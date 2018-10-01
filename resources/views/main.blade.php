<!DOCTYPE html>
<html lang="en">
    <head>
        @include('layouts._head')  
    </head>
    <body class="hidden-sn mdb-skin">
        @include('layouts._nav')
        @if(Request::is('/'))
            @include('layouts._slider')
        @endif
        <div class="container-fluid">
            @yield('content')
            @include('layouts._footer')
        </div>
        <!-- end of .container -->
        @include('layouts._script')
        <!-- add scripts -->
        @yield('scripts')
    </body>
</html>
