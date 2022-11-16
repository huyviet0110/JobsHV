<html lang="en">
<head>
    <meta charset="utf-8">
    <title>JobsHV</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- App css -->
    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/app-creative-dark.min.css') }}" rel="stylesheet" type="text/css">

    @stack('css')
</head>

<body class=""
      data-layout-config="{&quot;leftSideBarTheme&quot;:&quot;dark&quot;,&quot;layoutBoxed&quot;:false, &quot;leftSidebarCondensed&quot;:false, &quot;leftSidebarScrollable&quot;:false,&quot;darkMode&quot;:false, &quot;showRightSidebarOnStart&quot;: true}"
      data-leftbar-theme="dark">
<!-- Begin page -->
@extends('layout.sidebar')

<div class="wrapper mm-active">
    @extends('layout.header')

    <div class="content-page">
        <div class="content">
            @extends('layout.header')

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    @extends('layout.footer')
</div>
<!-- END wrapper -->

<script src="{{ asset('js/app.min.js') }}"></script>
<script src="{{ asset('js/vendor.min.js') }}"></script>

@stack('js')

</body>
</html>
