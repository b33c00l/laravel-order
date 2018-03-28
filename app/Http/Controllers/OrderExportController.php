<?php

namespace App\Http\Controllers;

use App\Services\ExportToExcelService;
use Excel;
use App\OrderProduct;

class OrderExportController extends Controller
{
    public function __construct(ExportToExcelService $exportExcelService)
    {
        $this->exportExcelService = $exportExcelService;
    }
    public function export($type)
    {
        Excel::create('orders', function($excel) use (&$type){
            $excel->sheet('orders', function ($sheet) use (&$type){
                $orders = $this->exportExcelService->checkType($type);
                if (count($orders) <= 0)
                {
                    return redirect()->back();
                }
                foreach ($orders as $order)
                {
                    $orders_id[] = $order->id;
                    foreach ($order->orderProducts()->get() as $product)
                    {
                        $product_id[] = $product->product_id;
                    }
                }
                $orderProducts = OrderProduct::whereIn('product_id', $product_id)->InOrders($orders_id)->get()->unique('product_id');
                $sheet->loadView('ExportOrders', compact(['orders', 'orderProducts', 'type']));
            });
        })->export('xlsx');
    }
}
