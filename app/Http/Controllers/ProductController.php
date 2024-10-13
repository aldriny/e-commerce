<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use App\Helpers\ErrorHandler;
use App\Http\Requests\CartRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    protected $errorHandler;
    public function __construct(ErrorHandler $errorHandler)
    {
        $this->errorHandler = $errorHandler;
    }
    
    public function index()
    {
        try{
            $products = Product::paginate(9);
            $favourites = Auth::check() ? Auth::user()->favourites()->pluck('product_id')->toArray() : [];
            return view('products.index',['products' => $products,'favourites' => $favourites]);
        }
        catch(Exception $e){
            return $this->errorHandler->handleException($e,'Error fetching products');
        }
    }

    public function show($id)
    {
        try{
            $product = Product::findOrFail($id);
            return view('products.show',['product' => $product]);
        }
        catch(Exception $e){
            return $this->errorHandler->handleException($e,'Error fetching product');
        }
    }
}
