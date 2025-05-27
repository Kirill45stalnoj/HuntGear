<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Список категорий
    public function index()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.categories.index', compact('categories'));
    }

    // Форма создания
    public function create()
    {
        return view('admin.categories.create');
    }

    // Создание категории
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create($request->only('name'));

        return redirect()->route('categories.index')->with('success', 'Категория добавлена.');
    }

    // Форма редактирования
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // Обновление категории
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update($request->only('name'));

        return redirect()->route('categories.index')->with('success', 'Категория обновлена.');
    }

    // Удаление категории
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Категория удалена.');
    }
}
