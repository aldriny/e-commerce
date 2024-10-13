<?php

namespace App\Http\Controllers\ApiControllers;

use Exception;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Helpers\ErrorHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use Symfony\Component\HttpFoundation\Response;

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
            $categories = Category::paginate(10);
            return response()->json([
                'message' => 'Categories fetched successfully',
                'data' => CategoryResource::collection($categories),
            ],Response::HTTP_OK);
        }
        catch (Exception $e) {
            return $this->errorHandler->handleException($e, 'Error fetching categories');
        }
    }

    public function store(CategoryRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $category = Category::create($validatedData);
            return response()->json([
               'message' => 'Category created successfully',
                'data' => new CategoryResource($category),
            ], Response::HTTP_CREATED);
        }
        catch (Exception $e) {
            return $this->errorHandler->handleException($e, 'Error creating category');
        }
    }

    public function show($id)
    {
        try {
            $category = Category::findOrFail($id);
            return response()->json([
               'message' => 'Category fetched successfully',
                'data' => new CategoryResource($category),
            ], Response::HTTP_OK);
        }
        catch (Exception $e) {
            return $this->errorHandler->handleException($e, 'Error fetching category');
        }
    }

    public function update(CategoryRequest $request, $id)
    {
        try {
            $category = Category::findOrFail($id);
            $validatedData = $request->validated();
            $category->update($validatedData);
            return response()->json([
               'message' => 'Category updated successfully',
                'data' => new CategoryResource($category),
            ], Response::HTTP_OK);
        }
        catch (Exception $e) {
            return $this->errorHandler->handleException($e, 'Error updating category');
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = Category::where('id', $id)->delete();    
            if ($deleted) {
                return response()->json([
                    'message' => 'Category deleted successfully'
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'message' => 'Category not found'
                ], Response::HTTP_NOT_FOUND);
            }
        }
        catch (Exception $e) {
            return $this->errorHandler->handleException($e, 'Error deleting category');
        }
    }
    
}
