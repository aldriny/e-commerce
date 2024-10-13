<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Category;
use App\Helpers\ErrorHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;

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
            return view('admin.categories.index', ['categories' => $categories]);
        }
        catch (Exception $e) {
            return $this->errorHandler->handleException($e, 'Error fetching categories');
        }
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(CategoryRequest $request)
    {
        try {
            $validatedData = $request->validated();
            Category::create($validatedData);
            return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
        }
        catch (Exception $e) {
            return $this->errorHandler->handleException($e, 'Error creating category');
        }
    }

    public function show($id)
    {
        try {
            $category = Category::findorFail($id);
            return view('admin.categories.show', ['category' => $category]);
        }
        catch (Exception $e) {
            return $this->errorHandler->handleException($e, 'Error fetching category');
        }
    }

    public function edit($id)
    {
        try {
            $category = Category::findorFail($id);
            return view('admin.categories.edit', ['category' => $category]);
        }
        catch (Exception $e) {
            return $this->errorHandler->handleException($e, 'Error fetching category');
        }
    }

    public function update(CategoryRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
            $category = Category::findorFail($id);
            $category->update($validatedData);
            return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
        }
        catch (Exception $e) {
            return $this->errorHandler->handleException($e, 'Error updating category');
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::where('id',$id)->delete();
            return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
        }
        catch (Exception $e) {
            return $this->errorHandler->handleException($e, 'Error deleting category');
        }
    }
}
