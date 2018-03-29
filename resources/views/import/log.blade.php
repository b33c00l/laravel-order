@extends('layouts.main', ['title' => 'Import products log'])

@section('content')
<div class="col-10">
    <div class="row">
        <div class="col-12 mt-5 mb-5 text-center">
            <h2>Import products log</h2>
        </div>
        <div class="col-12">
            <form method="post" action="{{route('products.import.filter')}}">
                @csrf
                <div class="input-group">
                  <select class="custom-select" id="inputGroupSelect04">
                    <option value="all">All</option>
                    <option value="{{ \App\ImportItem::WAITING }}">Waiting</option>
                    <option value="{{ \App\ImportItem::IN_PROGRESS }}">In progress</option>
                    <option value="{{ \App\ImportItem::DONE }}">Success</option>
                    <option value="{{ \App\ImportItem::FAIL }}">Fail</option>
                </select>
                <div class="input-group-append">
                    <button class="btn btn-outline-dark" type="submit">Filter</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-12">
        <table>
            <thead>
                <tr>
                    <th>Line</th>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Error</th>
                    <th>Upload time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($all as $line => $one_line)
                <tr>
                    <td>{{($all->currentpage()-1) * $all->perpage() + $line + 1}}</td>
                    <td>{{$one_line->product_id}}</td>
                    <td>
                        @if($one_line->product_id !== null)
                        <a href="{{ route('products.show', $one_line->product_id) }}">{{$one_line->product_name}}</a>
                        @endif
                    </td>
                    <td>
                        @if ($one_line->status == \App\ImportItem::FAIL)
                        <span class="text-danger">{{$one_line->import_status}}</span>
                        @else
                        {{$one_line->import_status}}
                        @endif
                    </td>
                    <td>{{$one_line->error_message}}</td>
                    <td>{{$one_line->updated_at}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="col-12 d-flex justify-content-center mt-3">
    {{$all->links()}}
</div>
</div>
</div>
@endsection