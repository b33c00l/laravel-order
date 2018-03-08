<form action="{{ route('products.update', ['id' => $product->id])}}" method="post">
    @csrf
    <div class="form-group">
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul>
            @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
            @endforeach
                </ul>
            </div>
        @endif
        <input type="hidden" name="_method" value="put">

            <label for="name">Name:</label>
            <br>
            <input type="text" name="name" class="form-control" placeholder="Product name" value="{{ old('name', $product->name) }}">
            <br>
            <label for="ean">EAN:</label>
            <br>
            <input type="number" name="ean" class="form-control" placeholder="EAN" value="{{ old('ean', $product->ean) }}">
            <br>
            <label for="price_amount">Price:</label>
            <br>
            <input type="text" step="0.01" name="price_amount" class="form-control" placeholder="Price" value="{{ old('price_amount', $product->price->last()->amount) }}">
            <br>
            <label for="stock_amount">Stock:</label>
            <br>
            <input type="number" name="stock_amount" class="form-control" placeholder="Stock" value="{{ old('stock_amount', $product->stock->last()->amount) }}">
            <br>
            <label for="platform">Platform:</label>
            <br>
            <div class="form-radio">
                @foreach ($platforms as $platform)
                    <input type="radio" class="form-radio-input" name="platform_id" value="{{ $platform->id }}" id="{{ $platform->id }}"
                        @if (old('platform_id', $product->platform->id) == $platform->id) checked @endif>
                    <label for="{{ $platform->name }}" class="form-radio-label">{{ $platform->name}} </label>
                @endforeach
            </div>
            <br>
            <label for="publisher">Publisher:</label>
            <br>
            <div class="form-radio">
                @foreach($publishers as $publisher)
                    @if (empty($product->publisher->id ))
                        <input type="radio" class="form-radio-input" name="publisher_id" id="{{ $publisher->id }}" value="{{ $publisher->id }}"
                               @if (old('publisher_id') == $publisher->id) checked @endif>
                    @else
                        <input type="radio" class="form-radio-input" name="publisher_id" id="{{ $publisher->id }}" value="{{ $publisher->id }}"
                               @if (old('publisher_id', $product->publisher->id) == $publisher->id) checked @endif>
                    @endif

                    <label for="{{ $publisher->name }}" class="form-radio-label">{{ $publisher->name }}</label>
                @endforeach
            </div>

            <br>
            <label for="description">Description:</label>
            <br>
            <textarea type="text" name="description" id="description" class="form-control"
                      placeholder="Product description">{{ old('description', $product->description) }}</textarea>
            <br>
            <label for="release_date">Release Date:</label>
            <br>
            <input type="date" name="release_date" class="form-control" value="{{  old('release_date', $product->release_date) }}">
            <br>
            <label for="video">Video</label>
            <br>
            <input type="text" name="video" class="form-control" value="{{ old('video', $product->video) }}">
            <br>
            <label for="pegi">Pegi</label>
            <br>
            <input type="number" name="pegi" class="form-control" value="{{ old('pegi', $product->pegi) }}">
            <br>
            <button type="submit" class="btn btn-secondary">Submit</button>
    </div>
</form>