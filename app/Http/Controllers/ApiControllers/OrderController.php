<?php

namespace App\Http\Controllers\ApiControllers;

use Exception;
use App\Models\OrderItem;
use App\Helpers\ErrorHandler;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OrderRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    protected $errorHandler;
    public function __construct(ErrorHandler $errorHandler)
    {
        $this->errorHandler = $errorHandler;
    }

    public function index()
    {
        try {
            $orders = Auth::user()->orders()->with([
                'orderItems' => function ($query) {
                    $query->select(['order_id', 'id', 'product_id', 'price', 'quantity']);
                }
            ])->get();
            if ($orders->isEmpty()) {
                return response()->json([
                    'message' =>  'No orders yet',
                ], Response::HTTP_NOT_FOUND);
            }
            return response()->json([
                'message' => 'Orderes retrieved successfully',
                'orders' =>  $orders,
            ]);
        } catch (Exception $e) {
            return $this->errorHandler->handleException($e);
        }
    }

    public function store(OrderRequest $request)
    {
        $products = $request->validated()['products'];
        try {
            $order =  DB::transaction(function () use ($products) {
                $order = Auth::user()->orders()->create([
                    'total' => $this->calculateTotal($products),
                    'status' => 'pending'
                ]);

                $items = array_map(function ($product) use ($order) {
                    return [
                        'order_id' => $order->id,
                        'product_id' => $product['product_id'],
                        'price' => $product['price'],
                        'quantity' => $product['quantity'],
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }, $products);

                OrderItem::insert($items);

                $order = $order->load('orderItems');
                return $order;
            });
            return response()->json([
                'message' => 'Order created successfully',
                'order' => $order
            ]);
        } catch (Exception $e) {
            return $this->errorHandler->handleException($e);
        }
    }

    public function show($orderId)
    {
        try {
            $order = Auth::user()->orders()->with([
                'orderItems' => function ($query) {
                    $query->select(['order_id', 'id', 'product_id', 'price', 'quantity']);
                }
            ])->findOrFail($orderId);

            return response()->json([
                'message' => 'Order retrieved successfully',
                'orders' =>  $order,
            ]);
        } catch (Exception $e) {
            return $this->errorHandler->handleException($e);
        }
    }

    public function destroy($orderId)
    {
        try {
            $order = Auth::user()->orders()->findOrFail($orderId);
            $order->delete();
            return response()->json([
                'message' => 'Order deleted successfully',
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return $this->errorHandler->handleException($e);
        }
    }

    private function calculateTotal($products)
    {
        $total = 0;
        foreach ($products as $product) {
            $total += $product['price'] * $product['quantity'];
        }
        return $total;
    }
}
