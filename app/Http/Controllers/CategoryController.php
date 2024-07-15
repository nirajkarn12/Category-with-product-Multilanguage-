<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\EditCategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('navbar', compact('categories'));
    }

    public function getProducts(Category $category)
    {
        return response()->json($category->products);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['message' => 'Category deleted successfully']);
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = $request->createCategory();

        return response()->json($category, 200);
    }

    public function update(EditCategoryRequest $request, Category $category)
{
    $category = $request->updateCategory($category);

    return response()->json(['message' => 'Category has been successfully edited', 'category' => $category], 200);
}

}

// return response()->json(['message' => 'Category has been succesfully edited ', 'category' => $category], 200);