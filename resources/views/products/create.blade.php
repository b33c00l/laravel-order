<form action="{{ route('products.store') }}" method="post">
    @csrf
    <div class="form-group">
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <label for="name">Name:</label>
        <br>
        <input type="text" name="name" class="form-control" placeholder="Product name" value="{{ old('name') }}">
        <br>
        <label for="ean">EAN:</label>
        <br>
        <input type="number" name="ean" class="form-control" placeholder="EAN" value="{{ old('ean') }}">
            <br>
        <label for="stock_amount">Stock:</label>
        <br>
        <input type="number" name="stock_amount" class="form-control" placeholder="Available stock" value="{{ old('stock_amount') }}">
        <br>
        <label for="price_amount">Price:</label>
        <br>
        <input type="text" step="0.01" name="price_amount" class="form-control" placeholder="Price" value="{{ old('price_amount') }}">
        <br>
        <label for="platform">Platform:</label>
        <br>
        <div class="form-radio">
            @foreach($platforms as $platform)
                @if ($platform->id == old('platform_id'))
                    <input type="radio" class="form-radio-input" name="platform_id" value="{{ $platform->id }}"
                       id="{{ $platform->id }}" checked>
                @else
                    <input type="radio" class="form-radio-input" name="platform_id" value="{{ $platform->id }}"
                       id="{{ $platform->id }}" >
                @endif
                <label for="{{ $platform->name }}" class="form-radio-label">{{ $platform->name }}</label>
            @endforeach
        </div>
        <br>
        <label for="publisher">Publisher:</label>
        <br>
        <div class="form-radio">
            @foreach($publishers as $publisher)
                @if ($publisher->id == old('publisher_id'))
                <input type="radio" class="form-radio-input" name="publisher_id" value="{{$publisher->id}}"
                       id="{{ $publisher->id }}" checked>
                @else
                    <input type="radio" class="form-radio-input" name="publisher_id" value="{{$publisher->id}}"
                       id="{{ $publisher->id }}">
                @endif
                <label for="{{$publisher->name}}" class="form-radio-label">{{$publisher->name}}</label>
            @endforeach
        </div>

        <br>
        <label for="description">Description:</label>
        <br>
        <textarea type="text" name="description" id="description" class="form-control"
                  placeholder="Product description">{{ old('description') }}</textarea>
        <br>
        <label for="release_date">Release Date:</label>
        <br>
        <input type="date" name="release_date" class="form-control" value="{{ old('release_date') }}">
        <br>
        <label for="video">Video</label>
        <br>
        <input type="text" name="video" class="form-control" value="{{ old('video') }}">
        <br>
        <label for="pegi">Pegi</label>
        <br>
        <input type="number" name="pegi" class="form-control" value="{{ old('pegi') }}">
        <br>
        <button type="submit" class="btn btn-secondary">Submit</button>
    </div>
</form>