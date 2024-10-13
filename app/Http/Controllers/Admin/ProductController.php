<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Product;
use App\Models\Category;
use App\Helpers\ErrorHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $errorHandler;

    public function __construct(ErrorHandler $errorHandler){
        $this->errorHandler = $errorHandler;
    }

    public function index()
    {
        try{
            $products = Product::paginate(10);
            return view('admin.products.index',['products' => $products]);
        }
        catch(Exception $e){
            return $this->errorHandler->handleException($e,'Error fetching products');
        }
    }

    public function create()
    {
        try{
            $categories = Category::all();
            return view('admin.products.create',['categories' => $categories]);
        }
        catch(Exception $e){
            return $this->errorHandler->handleException($e,'Error fetching categories');
        }
    }

    public function store(ProductRequest $request)
    {
        try{
            $validatedData = $request->validated();
            if($request->hasFile('image')){
                $validatedData['image'] = Storage::putFile('products',$request->file('image'));
            }
            Product::create($validatedData);
            return redirect()->route('admin.products.index')->with('success','Product created successfully');
        }
        catch(Exception $e){
            return $this->errorHandler->handleException($e,'Error creatinf product');
        }
    }

    public function show($id)
    {
        try{
            $product = Product::findOrFail($id);
            return view('admin.products.show',['product' => $product]);
        }
        catch(Exception $e){
            return $this->errorHandler->handleException($e,'Error fetching product');
        }
    }

    public function edit($id)
    {
        try{
            $product = Product::findOrFail($id);
            $categories = Category::all();
            return view('admin.products.edit',['product' => $product, 'categories' => $categories]);
        }
        catch(Exception $e){
            return $this->errorHandler->handleException($e,'Error fetching product');
        }
    }

    public function update(ProductRequest $request, $id)
    {
        try{
            $validatedData = $request->validated();
            $product = Product::findorFail($id);
            if($request->hasFile('image')){
                Storage::delete($product->image);
                $validatedData['image'] = Storage::putFile('products',$request->file('image'));
            }
            $product->update($validatedData);
            return redirect()->route('admin.products.index')->with('success','Product updated successfully');
        }
        catch(Exception $e){
            return $this->errorHandler->handleException($e,'Error updating product');
        }
    }

    public function destroy($id)
    {
        try{
            $product = Product::findOrFail($id);
            Storage::delete($product->image);
            $product->delete();
            return redirect()->route('admin.products.index')->with('success','Product deleted successfully');
        }
        catch(Exception $e){
            return $this->errorHandler->handleException($e,'Error deleting product');
        }
    }


}
