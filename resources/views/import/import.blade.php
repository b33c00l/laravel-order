@extends('layouts.page', ['title' => 'Import products'])

@section('content')
<div class="col-10">
    <div class="row">
        <div class="col-12 mt-5 text-center">
            <h2>Import products</h2>
        </div>
        <div class="col-sm-6 mx-auto">
            @if($errors->has('file'))
            <small class="alert alert-danger">
                {{ $errors->first('file') }}
            </small>
            @endif
            @if (Session::has('error'))
            <small class="alert alert-danger">
                {{ Session::get('error') }}
            </small>
            @endif
            @if (Session::has('success'))
            <small class="alert alert-success">
                {{ Session::get('success') }}
            </small>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 mx-auto mt-4">
            <form action="{{ route('products.import') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Import file</span>
                    </div>
                        <div class="col-12">
                            <input class="form-control" type="file" name="file">
                        </div>
                </div>

                <div class="d-flex justify-content-center">
                <button class="btn btn-dark btn-block" type="submit" name="submit" value="Import">Import</button>
            </div>
            </div>
        </form>
    </div>
</div>
</div>
</div>
@endsection