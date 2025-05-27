<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Size;

class CartController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Войдите, чтобы просмотреть корзину.');
        }
        $cart = session()->get('cart', []);
        $categories = \App\Models\Category::orderBy('name')->get();
        return view('cart', compact('cart', 'categories'));
    }

    public function addToCart(Request $request, $id)
    {
        $product = Product::with('category')->findOrFail($id);
        $validatedData = $request->validate([
            'size_id' => 'required|integer|exists:sizes,id',
        ]);

        $size = Size::findOrFail($validatedData['size_id']);

        $cart = session()->get('cart', []);

        $cartKey = $id . '-' . $validatedData['size_id'];

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity']++;
        } else {
            $cart[$cartKey] = [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image_url,
                'quantity' => 1,
                'size_id' => $validatedData['size_id'],
                'size' => $size->size,
                'category_id' => $product->category_id,
                'category_name' => $product->category->name
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart')->with('success', 'Товар добавлен в корзину!');
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart')->with('success', 'Товар удален из корзины.');
    }

    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->route('cart')->with('success', 'Корзина очищена.');
    }

    public function createOrder(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Пожалуйста, войдите в систему.');
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Корзина пуста!');
        }

        $request->validate([
            'address' => 'required|string',
            'payment_method' => 'required|string',
            'phone' => 'required|string|max:20',
            'comment' => 'nullable|string|max:255',
        ]);

        // Создание нового заказа
        $order = Order::create([
            'user_id' => Auth::id(),
            'address' => $request->input('address'),
            'payment_method' => $request->input('payment_method'),
            'status' => 'ожидание',
            'phone' => $request->input('phone'),
            'comment' => $request->input('comment'),
        ]);

        // Добавление товаров в заказ
        foreach ($cart as $cartKey => $item) {
            list($productId, $sizeId) = explode('-', $cartKey);
            
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        // Очистка корзины после создания заказа
        session()->forget('cart');

        return redirect()->route('cart')->with('success', 'Заказ успешно оформлен!');
    }

    public function updateQuantity(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            if ($request->action === 'increase') {
                $cart[$id]['quantity']++;
            } elseif ($request->action === 'decrease' && $cart[$id]['quantity'] > 1) {
                $cart[$id]['quantity']--;
            }

            // Сохраняем обновленную корзину
            session()->put('cart', $cart);
        }

        return redirect()->route('cart')->with('success', 'Количество товара обновлено.');
    }

    public function updateItem(Request $request)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$request->cart_id])) {
            $size = Size::findOrFail($request->size);
            $product = Product::with('category')->findOrFail(explode('-', $request->cart_id)[0]);
            
            $cart[$request->cart_id]['size_id'] = $request->size;
            $cart[$request->cart_id]['size'] = $size->size;
            $cart[$request->cart_id]['category_id'] = $product->category_id;
            $cart[$request->cart_id]['category_name'] = $product->category->name;
            $cart[$request->cart_id]['user_name'] = $request->name;
            $cart[$request->cart_id]['user_phone'] = $request->phone;

            session()->put('cart', $cart);
        }

        return redirect()->route('cart')->with('success', 'Заказ успешно обновлен!');
    }
}
