<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>Ecommerce - Material Kit PRO by Creative Tim</title>

    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">

    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">

    <!-- CSS Files -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/material-kit_v_1.2.1.css') }}">
    @stack('css')
</head>

<body class="ecommerce-page">
@include('layout_frontpage.navbar')
@include('layout_frontpage.header')

<div class="main main-raised">
    <div class="section">
        <div class="container">
            <h2 class="section-title">
                {{ __('frontpage.title') }}
            </h2>
            <div class="row">
                @include('layout_frontpage.sidebar')
                @yield('content')
            </div>
        </div>
    </div>
</div>

@include('layout_frontpage.footer')

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/material.min.js') }}"></script>
<script src="{{ asset('js/nouislider.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-tagsinput.js') }}"></script>
<script src="{{ asset('js/material-kit_v_1.2.1.js') }}"></script>
<script type="text/javascript">
		$(document).ready(function(){

			var slider2 = document.getElementById('sliderRefine');

			noUiSlider.create(slider2, {
				start: [42, 880],
				connect: true,
				range: {
				   'min': [30],
				   'max': [900]
				}
			});

			var limitFieldMin = document.getElementById('price-left');
			var limitFieldMax = document.getElementById('price-right');

			slider2.noUiSlider.on('update', function( values, handle ){
				if (handle){
					limitFieldMax.innerHTML= $('#price-right').data('currency') + Math.round(values[handle]);
				} else {
					limitFieldMin.innerHTML= $('#price-left').data('currency') + Math.round(values[handle]);
				}
			});
		});
</script>
@stack('js')

</body>
</html>
