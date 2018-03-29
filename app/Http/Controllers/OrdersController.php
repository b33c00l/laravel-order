<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeOrderStatusRequest;
use App\Order;
use Illuminate\Support\Facades\Auth;
use App\Services\InvoiceService;
use Illuminate\Support\Facades\Storage;


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
        $user = Auth::user();
        if($user->role == 'admin')
        {
            $orders = Order::paginate(20);
        }else{
            $orders = $user->orders()->paginate(20);
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
        $order = Order::findOrFail($id);
        if ($request->action === 'confirm'){
            $status = Order::CONFIRMED;
        }elseif($request->action === 'reject'){
            $status = Order::REJECTED;
        }
        $file=$request->file('invoice');
        if(isset($file))
        {
            if (empty($order->invoice))
            {
                $filenameWithExt = $this->checkInvoice->uploadInvoice($file);
                $order->invoice()->create($request->except('_token') + [
                        'filename' => $filenameWithExt,
                    ]);
            }else {
                Storage::delete('public/invoices/'.$order->invoice->filename);
                $filenameWithExt = $this->checkInvoice->uploadInvoice($file);
                $order->invoice->update($request->except('_token') + [
                        'filename' => $filenameWithExt,
                    ]);
            }
        }
        $order->update(['status' => $status]);

        return redirect()->route('order.orders');
    }

    public function download($id)
    {
        $order = Order::findOrFail($id);
        if (!empty($order->invoice->filename))
        {
            $path = storage_path('app/public/invoices/'.$order->invoice->filename);

            return response()->download($path);
        }
        return redirect()->back();
    }
}
