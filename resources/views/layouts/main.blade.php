<!DOCTYPE html>
<html>
<head>
	<title>@if (isset($title)) {{ $title }} @else Welcome @endif - Gamestar</title>
	<link rel="shortcut icon" href="{{asset('images/logo.png')}}">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
</head>
<body>
<div class="container">
	<!-- Header -->
@include('layouts.partials.header')
<!-- Sidebar -->
	<div class="row">
		@include('layouts.partials.sidebar')
	</div>
@yield('content')

<!-- New arrivals -->
	<hr>
	<div class="row">
		<div class="col-12 text-center mt-3">
			<h4>New arrivals</h4>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-sm-2 karuseles-arrow-containeris d-flex justify-content-center">
			<div class="karuseles-arrow prev"><i class="fa fa-caret-left"></i>
			</div>
		</div>
		<div class="col-sm-8 mt-3">
			<div class="karusele">

				@foreach ($products_latest as $product_latest)
					<div class="karuseles-img">
						<div class="row d-flex justify-content-center">
						<div class="karuseles-img-wrap d-flex justify-content-center">
						<a href="{{ route('products.show', array('id'=>$product_latest->id)) }}"><img class="gallery" src="{{ $product_latest->featured_image_url }}"></a>
						</div>
						<div class="col-12 mt-3">
						<a href="{{ route('products.show', array('id'=>$product_latest->id)) }}"><h6>{{ $product_latest->name }}</h6></a>
						</div>
						<div class="col-12">
						<a href="{{ route('products.show', array('id'=>$product_latest->id)) }}"><p>{{ $product_latest->platform->name }}</p></a>
						</div>
					</div>
					</div>
				@endforeach
			</div>
		</div>
		<div class="col-sm-2 karuseles-arrow-containeris d-flex justify-content-center">
			<div class="karuseles-arrow next"><i class="fa fa-caret-right"></i></div>
		</div>
	</div>
</div>

<div class="container-fluid">
	<div class="row">
		<div class="col-12 mt-5 text-center footer">
			<p>Copyright © GameStar 2018</p>
		</div>
	</div>
</div>
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</body>
</html>
