<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Helpers\ErrorHandler;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OrderRequest;
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
        DB::beginTransaction();
        try{
            $order = Auth::user()->orders()->create([
                'total' => $this->calculateTotal($request->products),
                'status' => 'pending'
            ]);
            
            //create order items in order_items table (order_id, product_id, price, quantity)
            foreach ($request->products as $product) {
                $order->orderItems()->create([
                    'product_id' => $product['product_id'],
                    'price' => $product['price'],
                    'quantity' => $product['quantity']
                ]);
            }
            DB::commit(); 
            session()->forget('cart');

            return redirect()->route('cart.index')->with('success', 'Order Placed successfully');
        }
        catch (Exception $e) {
            DB::rollBack();
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
