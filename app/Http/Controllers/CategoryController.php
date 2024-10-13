<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Category;
use App\Helpers\ErrorHandler;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{   
    protected $errorHandler;
    public function __construct(ErrorHandler $errorHandler)
    {
        $this->errorHandler = $errorHandler;
    }

    public function index()
    {
        try {
            $categories = Category::paginate(12);
            return view('categories.index', ['categories' => $categories]);
        }
        catch (Exception $e) {
            return $this->errorHandler->handleException($e, 'Error fetching categories');
        }
    }

    public function show($id)
    {
        try {
            $category = Category::findOrFail($id);
            $products = $category->products()->paginate(9);
            $favourites = Auth::check() ? Auth::user()->favourites()->pluck('product_id')->toArray() : [];
            return view('categories.show', ['category' => $category, 'products' => $products,'favourites' => $favourites]);
        }
        catch (Exception $e) {
            return $this->errorHandler->handleException($e, 'Error fetching category');
        }
    }
}
