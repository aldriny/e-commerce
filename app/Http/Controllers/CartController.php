<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Helpers\ErrorHandler;
use App\Http\Requests\CartRequest;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    protected $errorHandler;
    public function __construct(ErrorHandler $errorHandler)
    {
        $this->errorHandler = $errorHandler;
    }
    

    public function index()
    {
        $cart = Session::get('cart',[]);
        $totalPrice = $this->calculateTotalPrice($cart);
        return view('cart.index',compact('cart','totalPrice'));
    }

    public function store(CartRequest $request, $id)
    {  
        try{
            $orderedQuantity = $request->quantity;
            $product = Product::findOrFail($id);
            if($orderedQuantity > $product->quantity){
                return redirect()->back()->with('error','Insufficient stock');
            }

            $cart = Session::get('cart', []);
            if (isset($cart[$product->id])) {
                $cart[$product->id]['quantity'] += $orderedQuantity;
            }

            else{
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $orderedQuantity,
                'stock' => $product->quantity,
            ];
        }
            Session::put('cart', $cart);
            return redirect()->route('cart.index')->with('success','Product added to cart successfully');
        }
        catch(Exception $e){
            return $this->errorHandler->handleException($e,'Error adding product to cart');
        }
    }


    public function update(CartRequest $request, $id)
    {
        try {
            $orderedQuantity = $request->quantity;
            $product = Product::findOrFail($id);

            if ($orderedQuantity > $product->quantity) {
                return redirect()->back()->with('error', 'Insufficient stock');
            }

            $cart = session()->get('cart', []);
            if (isset($cart[$product->id])) {
                $cart[$product->id]['quantity'] = $orderedQuantity;
                $cart[$product->id]['total'] = $orderedQuantity * $product->price;
            }

            session()->put('cart', $cart);

            return redirect()->route('cart.index')->with('success', 'Quantity updated successfully');
        }
        catch (Exception $e) {
            return $this->errorHandler->handleException($e,'Error removing product from cart');
        }
    }

    public function destroy($id)
    {
        try{
            $cart = Session::get('cart', []);
            if(isset($cart[$id])){
                unset($cart[$id]);
                Session::put('cart', $cart);
                return redirect()->route('cart.index')->with('success','Product removed from cart successfully');
            }
            return redirect()->route('cart.index')->with('error','Product not found in cart');
        }
        catch(Exception $e){
            return $this->errorHandler->handleException($e,'Error removing product from cart');
        }
    }

    private function calculateTotalPrice($cart){
        $totalPrice = 0;
        foreach($cart as $productId => $product){
            $totalPrice += $product['price'] * $product['quantity'];
        }
        return $totalPrice;
    }
}
