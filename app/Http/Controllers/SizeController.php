<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Size;

class SizeController extends Controller
{
    public function getSizes($categoryId)
    {
        return response()->json(Size::where('category_id', $categoryId)->get());
    }
}
