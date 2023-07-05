<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $category = new Category;
        $category->name = $validatedData['name'];
        $category->parent_id = $validatedData['parent_id'];
        $category->save();

        return response()->json(['message' => 'Category created successfully']);
    }
}
