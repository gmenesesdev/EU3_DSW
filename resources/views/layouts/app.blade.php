<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <!-- AdminLTE -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Custom CSS -->
    @yield('css')
</head>

<body class="hold-transition sidebar-mini sidebar-collapse layout-fixed">
    <div class="wrapper">
        <!--Navbar-->
        @include('partials.navbar')
        <!--Sidebar-->
        @include('partials.sidebar')
        <!--Content Wrapper. Contains page content-->
        <div class="content-wrapper">

            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('page-title')</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6 text-end">
                            @yield('btn-add')
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </section><!-- /.content -->
            <section class="content">
                @yield('content')
            </section>
        </div>
        <!--Footer-->
        @include('partials.footer')
    </div>
    <!--.wrapper-->

    <!--JQuery-->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!--Bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- AdminLTE APP-->
    <script src="{{asset('dist/js/adminlte.min.js')}}"></script>
    <!--Custom JS-->
    @yield('scripts')
    
</body>

</html>
