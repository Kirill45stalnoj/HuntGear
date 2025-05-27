<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Exports\ReviewsExport;
use Maatwebsite\Excel\Facades\Excel;

class ReviewController extends Controller
{
    public function index()
    {
        // Получаем все отзывы
        $reviews = Review::with('user', 'product')->get();

        // Отправляем их в представление
        return view('admin.reviews.index', compact('reviews'));
    }
    public function store(Request $request, Product $product)
    {
        $user = Auth::user();

        // Проверка, что пользователь заказал товар и он был доставлен
        $order = $user->orders()
            ->whereHas('items', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })
            ->where('status', 'delivered') // Проверяем, что статус заказа "доставлен"
            ->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Вы можете оставить отзыв только после получения товара.');
        }

        // Проверяем, не оставлял ли пользователь уже отзыв на этот товар
        $existingReview = Review::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'Вы уже оставляли отзыв на этот товар.');
        }

        // Валидация данных отзыва
        $request->validate([
            'review' => 'required|string|max:500',
            'rating' => 'required|integer|between:1,5',
        ]);

        // Сохранение отзыва
        Review::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'review' => $request->review,
            'rating' => $request->rating,
        ]);

        return redirect()->back()->with('success', 'Отзыв успешно добавлен!');
    }
    // Метод для редактирования отзыва
    public function edit($reviewId)
    {
        $review = Review::findOrFail($reviewId);

        // Проверяем, может ли пользователь редактировать свой отзыв или является администратором
        if ($review->user_id == Auth::id() || Auth::user()->role == 'admin') {
            return view('admin.reviews.edit', compact('review'));
        }

        return redirect()->route('product.show', $review->product_id)->with('error', 'Вы не можете редактировать этот отзыв.');
    }

    // Метод для обновления отзыва
    public function update(Request $request, $reviewId)
    {
        $review = Review::findOrFail($reviewId);

        // Проверяем, может ли пользователь обновить свой отзыв или является администратором
        if ($review->user_id == Auth::id() || Auth::user()->role == 'admin') {
            $review->update($request->all());
            return redirect()->route('product.show', $review->product_id)->with('success', 'Отзыв обновлен.');
        }

        return redirect()->route('product.show', $review->product_id)->with('error', 'Вы не можете обновить этот отзыв.');
    }

    // Метод для удаления отзыва
    public function destroy($reviewId)
    {
        $review = Review::findOrFail($reviewId);

        // Проверяем, может ли пользователь удалить свой отзыв или является администратором
        if ($review->user_id == Auth::id() || Auth::user()->role == 'admin') {
            $review->delete();
            return redirect()->route('product.show', $review->product_id)->with('success', 'Отзыв удален.');
        }

        return redirect()->route('product.show', $review->product_id)->with('error', 'Вы не можете удалить этот отзыв.');
    }
    public function export()
    {
        return Excel::download(new ReviewsExport, 'reviews.xlsx');
    }
}
