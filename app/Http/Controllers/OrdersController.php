<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Http\Requests\ChangeOrderStatusRequest;

use App\Mail\OrderConfirmed;
use App\Mail\OrderRejected;

use App\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
        if ($user->role == 'admin') {
            $orders = Order::paginate(config('pagination.value'));
        } else {
            $orders = $user->orders()->paginate(config('pagination.value'));
        }
        return view('orders.orders', [
            'orders' => $orders,
        ]);
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        $chat = Chat::where('order_id', $id)->first();
        $products = $order->orderProducts;

        return view('orders.single_order', ['products' => $products, 'order' => $order, 'chat' => $chat]);
    }

    public function action(ChangeOrderStatusRequest $request, $id)
    {

        $userEmail = Auth::user()->client->email;

        $order = Order::findOrFail($id);
        if ($request->action === 'Confirm') {

            $status = Order::CONFIRMED;
            Mail::to($userEmail)->send(new OrderConfirmed($id));

        } elseif ($request->action === 'Reject') {
            $status = Order::REJECTED;
            Mail::to($userEmail)->send(new OrderRejected($id));
        }

        $file = $request->file('invoice');
        if (isset($file)) {
            $filenameWithExt = $this->checkInvoice->uploadInvoice($file);
            if (empty($order->invoice)) {
                $order->invoice()->create($request->except('_token') + [
                        'filename' => $filenameWithExt,
                    ]);
            } else {
                Storage::delete('public/invoices/' . $order->invoice->filename);
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
        if (!empty($order->invoice->filename)) {
            $path = storage_path('app/public/invoices/' . $order->invoice->filename);

            return response()->download($path);
        }
        return redirect()->back();
    }
}
