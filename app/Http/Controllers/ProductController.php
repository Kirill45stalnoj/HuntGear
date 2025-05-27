<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('reviews')
            ->get()
            ->sortByDesc(function ($product) {
                return $product->reviews->avg('rating');
            });
        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }
    public function favoriteProducts()
    {
        $user = auth()->user();
        $favorites = $user->favorites;

        return view('favorites.index', compact('favorites'));
    }
    public function show($id)
    {
        $product = Product::with(['category', 'sizes'])->findOrFail($id);
        $categories = Category::all();

        return view('product', compact('product', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image_url' => 'required|url|max:255',
            'category_id' => 'required|exists:categories,id',
            'sizes' => 'required|array',
            'sizes.*' => 'exists:sizes,id'
        ]);

        try {
            $product = Product::create([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'price' => $validatedData['price'],
                'image_url' => $validatedData['image_url'],
                'category_id' => $validatedData['category_id']
            ]);

            // Attach selected sizes to the product
            $product->sizes()->attach($validatedData['sizes']);

            return redirect()->route('admin.products')
                ->with('success', 'Товар успешно добавлен!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Произошла ошибка при добавлении товара: ' . $e->getMessage());
        }
    }
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image_url' => 'required|url|max:255',
            'category_id' => 'required|exists:categories,id'
        ]);

        try {
            $product->update($validatedData);

            return redirect()->route('admin.products')
                ->with('success', 'Товар успешно обновлен!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Произошла ошибка при обновлении товара: ' . $e->getMessage());
        }
    }
    public function destroy(Product $product)
    {
        // Проверяем, есть ли связанные заказы
        if ($product->orders()->exists()) {
            return redirect()->route('admin.products')
                ->with('error', 'Этот товар нельзя удалить, так как он находится в заказах пользователей.');
        }

        if ($product->image_url) {
            Storage::delete(str_replace('/storage/', 'public/', $product->image_url));
        }

        // Удаляем товар
        $product->delete();

        return redirect()->route('admin.products')
            ->with('success', 'Товар успешно удален.');
    }

}
