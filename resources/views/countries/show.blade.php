{{ $countriesSingle->name }}
<a href="{{ route('countries.edit',$countriesSingle->id) }}"><button>Edit</button></a>

<form action="{{ route('countries.destroy', ['id' => $countriesSingle->id])}}" method="post">
    @csrf
    <div class="form-group">
        <input type="hidden" name="_method" value="delete">
        <button type="submit" class="btn btn-secondary">Delete</button>
    </div>
</form>