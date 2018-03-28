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

class ExportToExcelService
{
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

    public function getQuantityAndPrice($product, $type)
    {
        $orders = $this->checkType($type);
        $result = '';
        foreach ($orders as $order)
        {
            $products = $order->orderProducts()->InProduct($product->id)->first();
                if (!empty($products)) {
                    $result .= "<td style='border-left: 5px solid'>" . $products->quantity . "</td>";
                    $result .= "<td style='border-right: 5px solid'>" . $products->price . "</td>";
                } else {
                    $result .= "<td style='border-left: 5px solid'></td>";
                    $result .= "<td style='border-right: 5px solid'></td>";
                }
            }
        return $result;
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
            switch ($type)
            {
                case 'order':
                    return Order::UnconfirmedOrder()->Order()->get();
                    break;
                case 'backorder':
                    return Order::UnconfirmedOrder()->Backorder()->get();
                    break;
                case 'preorder':
                    return Order::UnconfirmedOrder()->Preorder()->get();
                    break;
            }
        }else{
            switch ($type)
            {
                case 'order':
                    return $user->orders()->UnconfirmedOrder()->Order()->get();
                    break;
                case 'backorder':
                    return $user->orders()->UnconfirmedOrder()->Backorder()->get();
                    break;
                case 'preorder':
                    return $user->orders()->UnconfirmedOrder()->Preorder()->get();
                    break;
            }
        }
    }
}