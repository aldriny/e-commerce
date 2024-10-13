<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use App\Models\Favourite;
use Illuminate\Http\Request;
use App\Helpers\ErrorHandler;
use App\Models\User;
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
        try{
            $favourites = Auth::user()->favourites()->get();
            return view('favourites.index', compact('favourites'));
        }
        catch (Exception $e) {
            return $this->errorHandler->handleException($e);
        }
    }
    
    public function store($id)
    {
        try {
            $user = Auth::user();
            $product = Product::findOrFail($id);

            if ($user->favourites()->where('product_id',$product->id)->exists()) {
                $user->favourites()->detach($product->id);
                return redirect()->back();
            } else {
                $user->favourites()->attach($product->id);
                return redirect()->back();
            }
        } catch (Exception $e) {
            return $this->errorHandler->handleException($e);
        }
    }
}
