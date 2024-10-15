<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Helpers\ErrorHandler;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OrderRequest;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    protected $errorHandler;
    public function __construct(ErrorHandler $errorHandler)
    {
        $this->errorHandler = $errorHandler;
    }

    public function store(OrderRequest $request)
    {
        try{
             DB::transaction(function () use ($request) {
                $order = Auth::user()->orders()->create([
                    'total' => $this->calculateTotal($request->products),
                    'status' => 'pending'
                ]);  
                //create order items in order_items table (order_id, product_id, price, quantity)
                $orderItems = [];
                foreach ($request->products as $product) {
                    $orderItems[] = [
                        'order_id' => $order->id,
                        'product_id' => $product['product_id'],
                        'price' => $product['price'],
                        'quantity' => $product['quantity'],
                        'created_at' => now(),
                        'updated_at' => now()                    
                    ];
                }
                OrderItem::insert($orderItems);
                session()->forget('cart');
            });
            return redirect()->route('cart.index')->with('success', 'Order Placed successfully');
        }
        catch (Exception $e) {
            return $this->errorHandler->handleException($e,'Error placing order');
        }        

    }

    public function calculateTotal($products)
    {
        $total = 0;
        foreach ($products as $product) {
            $total += ($product['price'] * $product['quantity']);
        }
        return $total;
    }
}
