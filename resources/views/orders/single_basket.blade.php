<!DOCTYPE html>
<html>
<head>
    <title>Orders User</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href= "../css/style.css">
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
                @foreach($products as $product)
                <tr>
                    <td data-label="EAN:" class="align-middle">{{ $product->product->ean }}</td>
                    <td data-label="Platform:" class="align-middle">{{ $product->product->platform->name }}</td>
                    <td data-label="Name:" class="align-middle">{{ $product->product->name }}</td>
                    <td data-label="Release date:" class="align-middle">{{ $product->product->release_date }}</td>
                    <td data-label="Publisher:" class="align-middle">{{  $product->product->publisher->name }}</td>
                    <td data-label="Price:" class="align-middle">5</td>
                    <td data-label="Amount:" class="align-middle">
                        <input class="input" type="number" placeholder="30" name="amount" value="{{ $product->quantity }}">
                    </td>
                    <td class="align-middle">
                        <div class="btn btn-dark btn-sm">Update</div>
                        <div class="btn btn-danger btn-sm">Delete</div>
                    </td>
                </tr>
                    @endforeach
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
</body>