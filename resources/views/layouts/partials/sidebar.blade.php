				<div id="sidebar" class="col-2">
					<div class="col-12 text-center">
						@if(Auth::user()->role == 'admin')
							<h4>Admin panel</h4>
						@else
							<h4>User panel</h4>
						@endif
					</div>
					<div class="sidebar-categories">
						@include ('layouts.partials.sidebar_menu')
					</div>
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
							@foreach ($mpp as $popular_product)
								<div class="most-popular-prod-sidebar text-center">
									<a href="{{ route('products.show', $popular_product->id ) }}">
										<img id="popular" src="{{ $popular_product->FeaturedImageUrl }}" class="img-thumbnail">
									</a>
									<a href="{{ route('products.show', array('id'=>$popular_product->id)) }}">
										<h6 class="mt-2">{{ $popular_product->name }}</h6></a>
									<p class="text-center">{{ $popular_product->platform->name }}</p>
								</div>
							@endforeach
						</div>
					</div>