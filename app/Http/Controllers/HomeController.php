<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use App\Models\Category;
use App\Helpers\ErrorHandler;
use App\Http\Requests\SearchRequest;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected $errorHandler;
    public function __construct(ErrorHandler $errorHandler)
    {
        $this->errorHandler = $errorHandler;
    }

    public function home()
    {
        if (Auth::user() && Auth::user()->role === 'admin'){
            return view('admin.home');
        }
        else{
            try{
                $categories = Category::select('id','name')->orderBy('created_at','desc')->limit(6)->get();
                $products = Product::select('id','name', 'image', 'price')->orderBy('created_at','desc')->limit(9)->get();
                $favourites = Auth::check() ? Auth::user()->favourites()->pluck('product_id')->toArray() : [];
                return view('home',['categories' => $categories ,'products' => $products,'favourites' => $favourites]);
            }
            catch(Exception $e){
                return $this->errorHandler->handleException($e,'Error fetching products');
            }
        }
    }

    public function search(SearchRequest $request)
    {
        $search = $request->search;
        try{
            $products = Product::where('name','like',"%$search%")->paginate(12)->appends(['search' => $search]);
            return view('search', ['products' => $products, 'search' => $search]);
        }
        catch(Exception $e){
            return $this->errorHandler->handleException($e,'Error searching products');
        }
    }

}
