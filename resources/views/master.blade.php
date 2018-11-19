<!DOCTYPE html>
<html lang="en">
    <head>
        @include('partials._head')
    </head>
    <body class="grey lighten-3">
        <!--Main Navigation-->
        {{-- <header> --}}
            <!-- Navbar -->
            @include('partials._nav')
            <!-- Navbar -->

            <!-- Sidebar -->
            @include('partials._sidebar')
            <!-- Sidebar -->
        {{-- </header> --}}
        <!--Main Navigation-->

        <!--Main layout-->
        <main class="pt-5 mx-lg-5">
            <div class="container-fluid mt-5">
                @yield('content')
            </div>
        </main>
        <!--Main layout-->

        <!--Footer-->
        @include('layouts._footer')
        <!--/.Footer-->
        <!-- SCRIPTS -->
        @include('partials._script')
        <!-- add scripts -->
        @yield('scripts')
    </body>
</html>
