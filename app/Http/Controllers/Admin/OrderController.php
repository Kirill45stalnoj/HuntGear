<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;

class OrderController extends Controller
{
    // Показать список заказов
    public function index(Request $request)
    {
        $query = Order::query();

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $orders = $query->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Пожалуйста, войдите в систему');
        }
        // Валидируем входящие данные
        $validated = $request->validate([
            'address' => 'required|string|max:255',
            'payment_method' => 'required|string|in:card,cash',
            'comment' => 'nullable|string|max:255',
            'delivery_type' => 'required|string|in:courier,pickup',
            'phone' => 'required|string|max:20',
        ]);

        // Создаём новый заказ
        $order = new Order();
        $order->user_id = auth()->id();  
        $order->address = $validated['address'];
        $order->payment_method = $validated['payment_method'];
        $order->comment = $validated['comment'] ?? null;
        $order->delivery_type = $validated['delivery_type'];
        $order->status = 'ожидание'; 
        $order->phone = $validated['phone'];
        $order->save();

        return redirect()->route('order.index')->with('success', 'Заказ успешно оформлен');
    }

    public function show(Order $order)
    {
        // Убедитесь, что пользователь имеет доступ к заказу или является администратором
        if (!auth()->user()->isAdmin() && $order->user_id !== auth()->id()) {
            return response()->json([
                'error' => 'У вас нет доступа к этому заказу.',
            ], 403); 
        }

        // Добавляем вычисляемое свойство вручную
        $orderData = $order->toArray();
        $orderData['total_price'] = $order->total_price;

        return response()->json($orderData);
    }

    // Обновить статус заказа
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered',
        ]);

        $order->update(['status' => $validated['status']]);

        return redirect()->route('admin.orders.index')->with('success', 'Статус заказа обновлён');
    }

    // Удалить заказ
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Заказ удалён');
    }
}
