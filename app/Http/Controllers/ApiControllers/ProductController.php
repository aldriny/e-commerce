<?php

namespace App\Http\Controllers\ApiControllers;

use Exception;
use App\Models\Product;
use App\Helpers\ErrorHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    protected $errorHandler;

    public function __construct(ErrorHandler $errorHandler)
    {
        $this->errorHandler = $errorHandler;
    }

    public function index()
    {
        try {
            $products = Product::paginate(10);
            return response()->json([
                'message' => 'Products fetched successfully',
                'data' => ProductResource::collection($products)
            ], Response::HTTP_OK);
        }
        catch (Exception $e) {
            return $this->errorHandler->handleException($e, 'Error fetching products');
        }
    }

    public function store(ProductRequest $request)
    {
        try {
            $validatedData = $request->validated();
            if ($request->hasFile('image')) {
                $validatedData['image'] = Storage::put('products', $request->file('image'));
            }
            $product = Product::create($validatedData);
            return response()->json([
                'message' => 'Product created successfully',
                'data' => new ProductResource($product)
            ], Response::HTTP_CREATED);
        }
        catch (Exception $e) {
            return $this->errorHandler->handleException($e, 'Error creating product');
        }
    }

    public function show($id)
    {
        try {
            $product = Product::findOrFail($id);
            return response()->json([
                'message' => 'Product fetched successfully',
                'data' => new ProductResource($product)
            ], Response::HTTP_OK);
        }
        catch (Exception $e) {
            return $this->errorHandler->handleException($e, 'Error fetching product');
        }
    }

    public function update(ProductRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
            $product = Product::findOrFail($id);
            if ($request->hasFile('image')) {
                Storage::delete($product->image);
                $validatedData['image'] = Storage::put('products', $request->file('image'));
            }
            $product->update($validatedData);
            return response()->json([
                'message' => 'Product updated successfully',
                'data' => new ProductResource($product)
            ], Response::HTTP_OK);
        }
        catch (Exception $e) {
            return $this->errorHandler->handleException($e, 'Error updating product');
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            Storage::delete($product->image);
            $product->delete();
            return response()->json([
                'message' => 'Product deleted successfully',
            ], Response::HTTP_OK);
        }
        catch (Exception $e) {
            return $this->errorHandler->handleException($e, 'Error deleting product');
        }
    }
}
