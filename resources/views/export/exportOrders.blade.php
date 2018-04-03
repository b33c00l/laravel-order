@inject('exportService', "App\Services\ExportService")
<table>
    <thead>
        <tr>
            <th {!! !empty($orderProducts->first()->product->preorder) ? "colspan='8'" : "colspan='7'" !!}>{{ strtoupper($type) }}</th>
            @foreach($orders as $order)
                <th colspan="2" style='text-align: center; border-left: 5px solid; border-right: 5px solid'>{{ $order->user->name }}</th>
            @endforeach
        </tr>
        <tr>
            <th>Ean</th>
            <th>Name</th>
            <th>Release date</th>
            <th>Pegi</th>
            <th>Categories</th>
            <th>Platform</th>
            <th>Publisher</th>
            {!! !empty($orderProducts->first()->product->preorder) ? '<th>Pre-order</th>' : '' !!}
            @for($i = 0; $orders->count() > $i; $i++)
            <th style='border-left: 5px solid'>Quantity</th>
            <th style='border-right: 5px solid'>Price</th>
                @endfor
            <th>Total Quantity</th>
        </tr>
    </thead>
    <tbody>
            @foreach($orderProducts as $orderProduct)
            <tr>
                <td>{{ $orderProduct->product->ean }}</td>
                <td>{{ $orderProduct->product->name }}</td>
                <td>{{ $orderProduct->product->release_date }}</td>
                <td>{{ $orderProduct->product->pegi }}</td>
                <td>{{ $exportService->getCategories($orderProduct->product) }}</td>
                <td>{{ $orderProduct->product->platform->name }}</td>
                <td>{{ $orderProduct->product->publisher->name }}</td>
                {!! !empty($orderProduct->product->preorder) ? '<td>True</td>' : '' !!}
                @php
                    $orders = $exportService->checkType($type);
                    foreach ($orders as $order)
                    {
                        $products = $order->orderProducts()->InProduct($orderProduct->product->id)->first();
                        if (!empty($products)) {
                            echo "<td style='border-left: 5px solid'>" . $products->quantity . "</td>";
                            echo "<td style='border-right: 5px solid'>" . $products->price . "</td>";
                        } else {
                            echo "<td style='border-left: 5px solid'></td>";
                            echo "<td style='border-right: 5px solid'></td>";
                        }
                    }
                @endphp
                <td>{!! $exportService->getTotalQuantity($orderProduct->product, $type) !!}</td>
            </tr>
            @endforeach
    </tbody>
</table>