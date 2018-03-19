<!DOCTYPE html>
<html>
<head>
	<title>Index</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
</head>
<body>
	<div class="container">
		<!-- Top Bar -->
		<div class="row">
			<div class="top-bar">
				<ul>
					<li><i class="fa fa-phone-volume"></i>  <a href="#">+370 644 54348</a></li>
					<li><i class="fa fa-envelope"></i>  <a href="#">info@gamestar.eu</a></li>
				</ul>
			</div>
		</div>
		<!-- Header -->
		<div class="row">
			<div class="logo">
				<img src="{{asset('images/logo2.png')}}">
			</div>
			<div class="cart-menu-mobile">
				<span class="cart-menu-icon-mobile">
					<i class="fa fa-cart-arrow-down"></i>
				</span>
			</div>
			<div class="nav d-flex justify-content-end ">
				<nav class="navbar navbar-expand-lg navbar-light bg-light">
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<ul class="navbar-nav mr-auto">
							<li class="nav-item active">
								<a class="nav-link btn btn-outline-danger" href="{{ route('home') }}">Home <span class="sr-only">(current)</span></a>
							</li>
							<li class="nav-item">
								<a class="nav-link btn btn-danger" href="#">Order</a>
							</li>
							<li class="nav-item">
								<a class="nav-link btn btn-danger" href="#">Profile</a>
							</li>
							<li class="nav-item">
								<a class="nav-link btn btn-danger" href="{{ route('pages.contacts') }}">Contact</a>
							</li>
						</ul>
					</div>
				</nav>
			</div>
			<div class="cart-menu">
				<span class="cart-menu-inside">
					<span class="cart-menu-icon">
						<i class="fa fa-cart-arrow-down"></i>
					</span>
					<span class="cart-menu-price">Items: 0</span>
					<span class="cart-menu-price">€200</span>
				</span>
			</div>
		</div>
		<!-- Slider -->
		<div id="search" class="row justify-content-center">
			<div class="slider">
				<div>
					<img src="{{asset('images/slides/1.jpg')}}" />
				</div>
				<div>
					<img src="{{asset('images/slides/2.jpg')}}" />
				</div>
				<div>
					<img src="{{asset('images/slides/3.jpg')}}" />
				</div>
				<div>
					<img src="{{asset('images/slides/4.jpg')}}" />
				</div>
			</div>
			<div class="slider-arrows-left left"><i class="fa fa-arrow-circle-left"></i></div>
			<div class="slider-arrows-right right"><i class="fa fa-arrow-circle-right right"></i></div>
		</div>
		<!-- Search -->
		<div class="row">
			<div class="col-12 d-flex justify-content-center pt-3 pb-3 search-bar-back">
				<form class="form-inline justify-content-center">
					<input class="form-control mr-sm-2 search-inputas" type="search" placeholder="Search" aria-label="Search">
					<button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Search</button>
				</form>
			</div>
		</div>
		<!-- Sidebar -->
		<div class="row">
			<div id="sidebar" class="col-2">
				{{-- @admin --}}
				<div class="col-12 text-center">
					<h4>Admin panel</h4>
				</div>
				<div class="sidebar-categories">
					<ul class="list-group">
						<li>Orders</li>
						<ul>
							<li>Pre-Orders</li>
							<li>Back-Orders</li>
						</ul>
						<li>Users</li>
						<ul>
							<li>Add user</li>
						</ul>
						<li>Products</li>
						<ul>
							<li>Add product</li>
						</ul>
					</ul>
				</div>
				{{-- @endadmin --}}
				<div id="categories" class="row">
					<div class="col-12 text-center">
						<h4>Categories</h4>
					</div>
					<div class="sidebar-categories">
						<ul class="list-group">
							@foreach ($cats as $category)
							<li><a href="{{ route('products.cat', array('id'=>$category->id)) }}">{{$category->name}}</a></li>
							@endforeach
						</ul>
					</div>
				</div>
				<!-- Most popular -->
				<hr>
				<div id="popular" class="row">
					<div class="col-12 text-center">
						<h4>Most Popular</h4>
					</div>
					<div class="col-12">
						@for ($x = 0; $x < 3; $x++)
						<div class="most-popular-prod-sidebar text-center">
							<img id="popular" src="{{ $products_latest[$x]->featured_image_url }}"class="img-thumbnail">
							<h6 class="mt-2">{{ $products_latest[$x]->name }}</h6>
							<p>{{ str_limit($products_latest[$x]->description, 100) }}</p>
							<div class="row">
								<div class="input-group mb-3 d-flex justify-content-center">
									<input class="counter-inputas" type="number" name="amount">
									<div class="input-group-append">
										<a class="btn btn-dark" href="#">Add to Cart</a>
									</div>
								</div>
							</div>
						</div>
						@endfor
					</div>
				</div>
			</div>
			

			@yield('content')

			<!-- New arrivals -->
			<hr>
			<div class="row">
				<div class="col-12 text-center">
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
				<div class="col-sm-8">
					<div class="karusele">

						@foreach ($products_latest as $product_latest)
						<div class="karuseles-img">
							<img class="gallery" src="{{ $product_latest->featured_image_url }}">
							<h5>{{ $product_latest->name }}</h5>
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
