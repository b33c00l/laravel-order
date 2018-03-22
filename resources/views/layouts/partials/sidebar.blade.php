				<div id="sidebar" class="col-2">
					{{-- @admin --}}
					<div class="col-12 text-center">
						<h4>Admin panel</h4>
					</div>
					<div class="sidebar-categories">
						@include ('layouts.partials.sidebar_menu')
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
							@for ($x = 0; $x < 0; $x++)
							<div class="most-popular-prod-sidebar text-center">
								<a href="{{ route('products.show', array('id'=>$products_latest[$x]->id)) }}"><img id="popular" src="{{ $products_latest[$x]->featured_image_url }}" class="img-thumbnail"></a>
								<a href="{{ route('products.show', array('id'=>$products_latest[$x]->id)) }}"><h6 class="mt-2">{{ $products_latest[$x]->name }}</h6></a>
								<p>{{ str_limit($products_latest[$x]->description, 100) }}</p>
							</div>
							@endfor
						</div>
					</div>