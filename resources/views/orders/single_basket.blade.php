<!DOCTYPE html>
<html>
<head>
    <title>Orders User</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href= "{{ asset('css/style.css') }}">
</head>
<body>
<div class="container">

    <!-- Order table -->
    <div class="row">
        <div class="col-md-12">
            <table class="table table-sm">
                <thead class="thead-light">
                <tr>
                    <th scope="col">EAN:</th>
                    <th scope="col">Platform:</th>
                    <th scope="col">Name:</th>
                    <th scope="col">Release date:</th>
                    <th scope="col">Publisher:</th>
                    <th scope="col">Price:</th>
                    <th scope="col">Amount</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @if(!empty($products))
                @foreach($products as $product)
                <tr>
                    <td data-label="EAN:" class="align-middle">{{ $product->product->ean }}</td>
                    <td data-label="Platform:" class="align-middle">{{ $product->product->platform->name }}</td>
                    <td data-label="Name:" class="align-middle">{{ $product->product->name }}</td>
                    <td data-label="Release date:" class="align-middle">{{ $product->product->release_date }}</td>
                    <td data-label="Publisher:" class="align-middle">{{  $product->product->publisher->name }}</td>
                    <td data-label="Price:" class="align-middle">5</td>
                    <td data-label="Amount:" class="align-middle">
                        <input onkeyup="update_quantity({{ $product->id }},this.value)" class="input" type="number" name="amount" value="{{ $product->quantity }}">
                        <br>
                        <span style="display: none; color: green" id="update{{ $product->id }}" >updated</span>
                    </td>
                    <td class="align-middle">
                        <form action="{{route('order.product.delete', $product->id)}}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <!-- Comments and attachments -->
    <div class="row">
        <div class="col-12">
            <form>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1"><h4>Comments</h4></label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="6"></textarea>
                </div>
                <div class="form-group">
                    <a class="btn btn-danger btn-lg btn-block" href="#">Confirm your order</a>
                </div>
            </form>
        </div>
        <script
                src="https://code.jquery.com/jquery-3.3.1.js"
                integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
                crossorigin="anonymous"></script>
        <script>
            function update_quantity(id,quantity)
            {
                var token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    type: "post",
                    url: '{!! URL::to('update') !!}/' + id,
                    data: {quantity: quantity,_token: token},
                    dataType: "json",
                    success:function (data)
                    {
                        document.getElementById('update' + data).style.display = 'block';
                    }
                });
            }
        </script>
</body>