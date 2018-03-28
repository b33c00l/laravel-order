<?php
/**
 * Created by PhpStorm.
 * User: sevskis
 * Date: 3/27/18
 * Time: 14:03
 */

namespace App\Services;

use App\Order;
use App\OrderProduct;
use Illuminate\Support\Facades\Auth;
use Excel;

class ExportService
{
    public function generateExcel($type)
    {
        Excel::create($type, function($excel) use (&$type){
            $excel->sheet($type, function ($sheet) use (&$type){
                $orders = $this->checkType($type);
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
    public function getCategories($product)
    {
        $cat = '';
        $value = $product->categories->count();
        for ($i = 0; $value > $i; $i++)
        {
            if($value == ($i + 1))
            {
                $cat .= $product->categories[$i]->name. '.';
            }else{
                $cat .= $product->categories[$i]->name . ', ';
            }
        }
        return $cat;
    }

    public function getTotalQuantity($product, $type)
    {
        $quantity = 0;
        $orders = $this->checkType($type);
        $order_id = [];
        foreach ($orders as $order)
        {
            $order_id[] = $order->id;
        }
        $p = OrderProduct::InProduct($product->id)->InOrders($order_id)->get();
        foreach ($p as $q)
        {
            $quantity += $q->quantity;
        }
        return '<td>'.$quantity.'</td>';
    }

    public function checkType($type)
    {
        $user = Auth::user();
        if ($user->role == 'admin')
        {
            $query = Order::UnconfirmedOrder();
            return $this->orderType($query, $type);
        }else{
            $query = $user->orders()->UnconfirmedOrder();
            return $this->orderType($query, $type);
        }
    }
    public function orderType($query, $type)
    {
        switch ($type)
        {
            case 'order':
                $query = $query->Order();
                break;
            case 'backorder':
                $query = $query->Backorder();
                break;
            case 'preorder':
                $query->Preorder();
                break;
        }
        $query = $query->get();
        return $query;
    }
}