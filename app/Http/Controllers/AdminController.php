<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class AdminController extends Controller
{
    public function index()
    {
        // Проверка
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Доступ запрещен');
        }

        return view('admin.index');
    }
   
}
