<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;
use App\Models\Order;

class FavoriteController extends Controller
{
        public function index()
    {
        $favorites = Favorite::where('user_id', Auth::id())->with('product')->get();
        return view('favorites.index', compact('favorites'));
    }

    public function toggleFavorite($productId)
    {
        $user = Auth::user();

        // Проверяем, есть ли товар в избранном
        $favorite = Favorite::where('user_id', $user->id)->where('product_id', $productId)->first();

        if ($favorite) {
            $favorite->delete();
            return back()->with('success', 'Товар удален из избранного.');
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'product_id' => $productId,
            ]);
            return back()->with('success', 'Товар добавлен в избранное.');
        }
    }

    function lk (){
        $user=Auth::user();
        $favorites=$user ? $user->favorites : [];
        $orders = Order::where('user_id', auth()->id())->get();
        return view('dashboard', compact('favorites','orders'));
    }

}
