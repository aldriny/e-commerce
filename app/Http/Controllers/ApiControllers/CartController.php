<?php

namespace App\Http\Controllers\ApiControllers;

use Exception;
use App\Models\Cart;
use App\Models\User;
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
        try {
            $cartItems = Auth::user()->cartItems()->with([
                'product' => function ($query) {
                    $query->select(['id', 'name', 'price']);
                }
            ])->get();
            if ($cartItems->isEmpty()) {
                return response()->json([
                    'message' => 'Cart is empty'
                ]);
            }

            $cartItemsWithTotal = $cartItems->map(function ($cartItem) {
                $itemTotal = $cartItem->product->price * $cartItem->quantity;
                return [
                    'id' => $cartItem->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'product_name' => $cartItem->product->name,
                    'product_price' => $cartItem->product->price,
                    'item_total' => $itemTotal,
                ];
            });
            $cartTotal = $cartItemsWithTotal->sum('item_total');
            return response()->json([
                'cart_items' => $cartItemsWithTotal,
                'cart_total' => $cartTotal,
            ]);
        } catch (Exception $e) {
            return $this->errorHandler->handleException($e);
        }
    }

    public function store(CartRequest $request, $id)
    {
        // get validated data
        $orderedQuantity = $request->validated()['quantity'];
        try {
            return DB::transaction(function () use ($orderedQuantity, $id) {
                // get quantity from request and check against stock
                $product = Product::findOrFail($id);
                if ($orderedQuantity > $product->quantity) {
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
        } catch (Exception $e) {
            return $this->errorHandler->handleException($e);
        }
    }

    public function update(CartRequest $request, $id)
    {
        // get validated data
        $orderedQuantity = $request->validated()['quantity'];
        try {
            return DB::transaction(function () use ($orderedQuantity, $id) {
                // get quantity from request and check against stock
                $product = Product::findOrFail($id);
                if ($orderedQuantity > $product->quantity) {
                    return response()->json([
                        'message' => 'Insufficient stock'
                    ], Response::HTTP_BAD_REQUEST);
                }

                $cart = Auth::user()->cart;
                if (!$cart) {
                    return response()->json([
                        'message' => 'Cart not found'
                    ], Response::HTTP_NOT_FOUND);
                }
                $cartItem = $cart->cartItems()->where('product_id', $id)->first();
                if ($cartItem) {
                    $cartItem->update(['quantity' => $orderedQuantity]);
                    return response()->json([
                        'message' => 'Product updated in cart successfully',
                        'cart_items' => $cart->cartItems,
                    ]);
                } else {
                    return response()->json([
                        'message' => 'Product not found in cart'
                    ], Response::HTTP_NOT_FOUND);
                }
            });
        } catch (Exception $e) {
            return $this->errorHandler->handleException($e);
        }
    }

    public function destroy($id)
    {
        try {
            $cart  = Auth::user()->cart;
            if (!$cart) {
                return response()->json([
                    'message' => 'Cart not found'
                ], Response::HTTP_NOT_FOUND);
            }
            $cartItem = $cart->cartItems()->where('product_id', $id)->first();
            if ($cartItem) {
                $cartItem->delete();
                return response()->json([
                    'message' => 'Product removed from cart successfully',
                    'cart_items' => $cart->cartItems,
                ]);
            } else {
                return response()->json([
                    'message' => 'Product not found in cart'
                ], Response::HTTP_NOT_FOUND);
            }
        } catch (Exception $e) {
            return $this->errorHandler->handleException($e);
        }
    }
}
