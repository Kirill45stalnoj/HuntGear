<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all(); // Получаем все категории

        $products = Product::query();

        if ($request->has('category') && $request->category !== 'all') {
            $products->where('category_id', $request->category);
        }

        if ($request->has('price')) {
            $products->orderBy('price', $request->price);
        }

        return view('catalog', [
            'products' => $products->get(),
            'categories' => $categories
        ]);
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        $categories = Category::all();
        $products = Product::where('name', 'LIKE', "%{$query}%")->get();

        return view('catalog', compact('products', 'categories'));
    }
}