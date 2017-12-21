<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="CRUD Laravel">
    <meta name="author" content="Hector Dolo">
    <meta name="google-signin-client_id" content="149135955700-mptte3s01jl1cloulu7hceequp1f9jq1.apps.googleusercontent.com">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <!-- Bootstrap Core CSS -->
    <link href="{{ url('bower_components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{ url('bower_components/metisMenu/dist/metisMenu.min.css') }}" rel="stylesheet">

    <!-- jQuery -->
    <script src="{{ url('bower_components/jquery/dist/jquery.min.js') }}"></script>

    <!-- Custom CSS -->
    <link href="{{ url('dist/css/sb-admin-2.css') }}" rel="stylesheet">
    <link href="{{ url('dist/css/custom.css') }}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{ url('bower_components/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    @yield('header-scripts')

</head>

<body id="wrapper">

<nav class="navbar navbar-default navbar-static-top navbar-blue" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <!-- Branding Image -->
        <a class="navbar-brand mainLogo" href="{{ url('/') }}">
            <img src="/img/logo.png" alt="logo">
        </a>
    </div>

    <ul class="nav navbar-top-links navbar-right">
        <li><a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>

        <li><a href="{{ url('/report') }}"><i class="fa fa-line-chart" aria-hidden="true"></i> Report</a></li>

        <li>
            <div class="dropdown">
                <button class="dropbtn"><i class="fa fa-plus"></i> Create</button>
                <div class="dropdown-content">
                    <a href="{{ url('/create-worker') }}">Worker</a>
                    <a href="{{ url('/create-payment-method') }}">Payment method</a>
                    <a href="{{ url('/create-payment-type') }}">Payment type</a>
                    <a href="{{ url('/create-marketing-source') }}">Marketing Source</a>
                    <a href="{{ url('/create-transaction') }}">Transaction</a>
                </div>
            </div>
        </li>

        <li>
            <div class="dropdown">
                <button class="dropbtn"><i class="fa fa-bars"></i> Manage</button>
                <div class="dropdown-content">
                    <a href="{{ url('/workers') }}">Workers</a>
                    <a href="{{ url('/payment-methods') }}">Payment methods</a>
                    <a href="{{ url('/payment-types') }}">Payment types</a>
                    <a href="{{ url('/marketing-sources') }}">Marketing Sources</a>
                    <a href="{{ url('/transactions') }}">Transactions</a>
                </div>
            </div>
        </li>

        <li><a href="{{ url('/search') }}"><i class="fa fa-search"></i> Search</a></li>
        @if (Auth::check())
            <li>
                <a href="{{ url('/logout') }}"
                   onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out fa-fw"></i> Logout
                </a>

                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        @endif
    </ul>
</nav>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">@yield('page-header')</h3>
        </div>
    </div>

    @yield('page-content')

</div>
<!-- /#page-wrapper -->


<!-- Bootstrap Core JavaScript -->
<script src="{{ url('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
@yield('myjsfile')


<!-- Metis Menu Plugin JavaScript -->
<script src="{{ url('bower_components/metisMenu/dist/metisMenu.min.js') }}"></script>

<!-- Custom Theme JavaScript -->
<script src="{{ url('dist/js/sb-admin-2.js') }}"></script>


<script src="/js/index.js"></script>

@yield('footer-scripts')

</body>
</html>
