<ul class="list-group">
<li><a href="{{ route('order.orders') }}">Orders</a></li>
<ul>
<li>Pre-Orders</li>
<li>Back-Orders</li>
</ul>
<li><a href="{{ route('users.index') }}">Users</a></li>
<ul>
<li><a href="{{ route('users.create') }}">Add user</a></li>
</ul>
<li><a href="{{ route('publishers.index') }}">Publishers</a></li>
<ul>
<li><a href="{{ route('publishers.create') }}">Add publisher</a></li>
</ul>
<li><a href="{{ route('platforms.index') }}">Platforms</a></li>
<ul>
<li><a href="{{ route('platforms.create') }}">Add platform</a></li>
</ul>
<li><a href="{{ route('categories.index') }}">Categories</a></li>
<ul>
<li><a href="{{ route('categories.create') }}">Add category</a></li>
</ul>
<li><a href="{{ route('countries.index') }}">Countries</a></li>
<ul>
<li><a href="{{ route('countries.create') }}">Add country</a></li>
</ul>
<li><a href="{{ route('home') }}">Products</a></li>
<ul>
<li><a href="{{ route('products.create') }}">Add product</a></li>
</ul>
<ul>
<li><a href="{{ route('products.import.form') }}">Import products</a></li>
</ul>
<ul>
<li><a href="{{ route('products.import.log') }}">Products log</a></li>
</ul>
<ul>
<li><a href="{{ route('special.index') }}">Special offers</a></li>
</ul>
</ul>