<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class Review extends Model
{
    protected $fillable = ['user_id', 'product_id', 'review', 'rating'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function canEditOrDelete()
    {
        return Auth::user()->is_admin || Auth::id() === $this->user_id;
    }
}
