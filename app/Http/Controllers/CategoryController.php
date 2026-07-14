<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validData = $request->validate([
            'name'  => 'required|string|unique:categories,name|max:255',
        ]);
        Category::create($validData);
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambah');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validData = $request->validate([
            'name'  => 'required|string|unique:categories,name,'.$category->id.'|max:255',
        ]);
        $category->update($validData);
        return redirect()->route('admin.categories.index')->with('success', 'Berhasil diperbarui');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Berhasil dihapus');
    }
}
