<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permission:manage categories']);
    }

    // List categories
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->paginate(10);
        return view('categories.index', compact('categories'));
    }

    // Store new category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create(['name' => $request->name]);

        return response()->json(['success' => 'Category created successfully']);
    }

    // Edit category (AJAX fetch)
    public function edit(Category $category)
    {
        return response()->json($category);
    }

    // Update category
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update(['name' => $request->name]);

        return response()->json(['success' => 'Category updated successfully']);
    }

    // Delete category
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['success' => 'Category deleted successfully']);
    }
}