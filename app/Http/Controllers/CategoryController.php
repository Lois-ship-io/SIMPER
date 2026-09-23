<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Category::query();
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }
        $categories = $query->latest()->paginate(10)->withQueryString();
        
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);
        Category::create($data);
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();
        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        $category->update($data);
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
