<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Koki - Restaurant Food Laravel Admin Dashboard | Dashboard</title>
    <meta name="description" content="Some description for the page" />

    <link rel="icon" type="image/png" sizes="16x16" href="public/images/favicon.png">
    {{-- <link href="{{ asset('assetes/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet"
        type="text/css" /> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendor/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet"
        type="text/css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .custom-disabled {
            pointer-events: none;
            opacity: 0.5;
            background-color: #ccc;
            cursor: not-allowed;
        }
    </style>

    @yield('css')
</head>

<body>
    <div id="main-wrapper">
        <div class="nav-header">
            <a href="index.html" class="brand-logo">
                <img class="logo-abbr" src="{{ asset('assets/images/logo.png') }}" alt="" loading="lazy">
                <img class="logo-compact" src="{{ asset('assets/images/logo-text.png') }}" alt=""
                    loading="lazy">
                <img class="brand-title" src="{{ asset('assets/images/logo-text.png') }}" alt="" loading="lazy">
            </a>
            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>

        {{-- Header --}}
        @include('layouts.partials.header')
        {{-- Header --}}

        {{-- Menu --}}
        @include('layouts.partials.menu')
        {{-- Menu --}}

        <div class="content-body">
            <div class="container-fluid">
                <div class="row">
                    @yield('data')
                </div>
            </div>
        </div>
        <div class="footer">
            <div class="copyright">
                <p>Copyright © {{ date('Y') }}</p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/vendor/global/global.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/custom.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/deznav-init.js') }}" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('assets/vendor/datatables/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/plugins-init/datatables.init.js') }}" type="text/javascript"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @yield('js')
</body>

</html>
