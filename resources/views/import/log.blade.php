@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <form method="post" action="{{route('products.import.filter')}}">
                @csrf
                <select name="status">
                    <option value="all">All</option>
                    <option value="{{ \App\ImportItem::WAITING }}">Waiting</option>
                    <option value="{{ \App\ImportItem::IN_PROGRESS }}">In progress</option>
                    <option value="{{ \App\ImportItem::DONE }}">Success</option>
                    <option value="{{ \App\ImportItem::FAIL }}">Fail</option>
                </select>
                <button type="submit">Filter</button>
            </form>
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
        <div class="row ">
            <div class="col mx-auto">{{$all->links()}}</div>
        </div>
    </div>
@endsection