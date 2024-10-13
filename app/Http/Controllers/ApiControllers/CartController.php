<?php

namespace App\Http\Controllers\ApiControllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Helpers\ErrorHandler;
use App\Http\Requests\CartRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    protected $errorHandler;
    public function __construct(ErrorHandler $errorHandler)
    {
        $this->errorHandler = $errorHandler;
    }

    public function index()
    {

    }

    public function store(CartRequest $request,$id)
    {
        // get validated data
        $orderedQuantity = $request->validated()['quantity'];
        try{
            return DB::transaction(function () use ($orderedQuantity,$id){         
                // get quantity from request and check against stock
                $product = Product::findOrFail($id);
                if($orderedQuantity > $product->quantity){
                    return response()->json([
                        'message' => 'Insufficient stock'
                    ], Response::HTTP_BAD_REQUEST);
                }
                
                $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
                $cart->cartItems()->updateOrCreate(
                    ['product_id' => $id],
                    ['quantity' => $orderedQuantity]
                );
                return response()->json([
                    'message' => 'Product added to cart successfully',
                    'cart_items' => $cart->cartItems,
                ]);
            });
        }
        catch(\Exception $e){
            return $this->errorHandler->handleException($e);
        }

    }
}
