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
								<li><a href="{{ route('products.cat', $category->id) }}">{{$category->name}}</a></li>
								@endforeach
							</ul>
						</div>
					</div>