<?php

namespace App\Http\Controllers\ApiControllers;

use Exception;
use App\Models\Product;
use App\Helpers\ErrorHandler;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FavouriteController extends Controller
{
    protected $errorHandler;
    public function __construct(ErrorHandler $errorHandler)
    {
        $this->errorHandler = $errorHandler;
    }

    public function index()
    {
        try {
            $favourites = Auth::user()->favourites()->get();
            if ($favourites->isEmpty()) {
                return response()->json([
                    'message' => 'No favourites in the list'
                ]);
            }
            return response()->json([
                'message' => 'Favourites fetched successfully',
                'favourites' => $favourites
            ]);
        } catch (Exception $e) {
            return $this->errorHandler->handleException($e);
        }
    }


    public function store($id)
    {
        try {
            $user = Auth::user();
            $product = Product::findOrFail($id);
            if ($user->favourites()->where('product_id', $product->id)->exists()) {
                $user->favourites()->detach($product->id);
                return response()->json([
                    'message' => 'Product removed from favourites'
                ]);
            }
            $user->favourites()->attach($product->id);
            return response()->json([
                'message' => 'Product added to favourites'
            ]);
        } catch (Exception $e) {
            return $this->errorHandler->handleException($e);
        }
    }
}
