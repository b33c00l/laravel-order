<label for="">Name:</label>
{{ $productSingle->name }}
<br>
<label for="">EAN:</label>
{{ $productSingle->ean }}
<br>
<label for="">Price:</label>
{{ $productSingle->price->last()->amount }}
<br>
<label for="">Stock:</label>
{{ $productSingle->stock->last()->amount }}
<br>
<label for="">Platform:</label>
{{ $productSingle->platform->name }}
<br>
<label for="">Publisher:</label>
@if( empty($productSingle->publisher->name))
    -
@else
    {{ $productSingle->publisher->name }}
@endif
<br>
<label for="">Pegi:</label>
{{ $productSingle->pegi }}
<br>
<label for="">Video:</label>
<br>
{!! $productSingle->youtube_embed  !!}
<br>
<label for="">Description:</label>
{{ $productSingle->description }}
<br>
<a href="{{ route('products.edit',$productSingle->id) }}"><button>Edit</button></a>
<form action="{{ route('products.destroy', ['id' => $productSingle->id])}}" method="post">
    @csrf
    <div class="form-group">
        <input type="hidden" name="_method" value="delete">
        <button type="submit" class="btn btn-secondary">Delete</button>
    </div>
</form>