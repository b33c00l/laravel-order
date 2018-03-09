<form action="{{ route('images.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        @if ($errors->get('name'))
            @foreach($errors->get('name') as $error)
                <div class="alert alert-danger" role="alert">
                    {{ $error }}
                </div>
            @endforeach
        @endif
        <div class="form-group">
            <label for="category">Products</label>
            <div class="form-radio">
                @foreach ($products as $product)
                    <input class="form-radio-input" name="product_id" type="radio" value="{{ $product->id }}" id="{{ $product->name }}">
                    <label class="form-radio-label" for="{{ $product->name }}">{{ $product->name }}</label><br />
                @endforeach
            </div>
        </div>

        <input type="file" name="image[]" id="image" multiple>
        <br>

        <button type="submit" class="btn btn-secondary">Submit</button>
    </div>
</form>