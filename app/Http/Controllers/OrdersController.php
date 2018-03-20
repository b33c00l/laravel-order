<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeOrderStatusRequest;
use App\Invoice;
use App\Order;
use App\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Services\InvoiceService;


class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $checkInvoice;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->checkInvoice = $invoiceService;
    }

    public function index()
    {
        $user=Auth::user();
        if($user->role == 'admin')
        {
            $orders = Order::paginate(20);
        }else{
            $orders =$user->orders()->paginate(20);
        }

        return view('orders.orders', [
            'orders'=>$orders,
        ]);
    }
    public function show($id)
    {
        $order = Order::findOrFail($id);
        $products = $order->orderProducts;

        return view('orders.single_order', ['products'=> $products, 'order'=> $order]);
    }

    public function action(ChangeOrderStatusRequest $request, $id)
    {

        if ($request->action === 'confirm'){
            $status = Order::CONFIRMED;
        }elseif($request->action === 'reject'){
            $status = Order::REJECTED;
        }
        $file=$request->file('invoice');
        if (isset($file))
        {

            $filenameWithExt = $this->checkInvoice->generateName($file);

            Invoice::create($request->except('_token') + [
                    'filename' => $filenameWithExt,
                    'order_id' =>$id,
                ]);

            $file->storeAs('public/invoices', $filenameWithExt);
        }

        Order::findOrFail($id)->update(['status' => $status]);
        return redirect()->route('order.orders');
    }
}
