@if($errors->has($name))
    <small class="text-danger">
        {{ $errors->first($name) }}
    </small>
@endif