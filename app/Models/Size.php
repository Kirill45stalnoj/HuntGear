<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
class Size extends Model
{
    protected $fillable = ['category_id', 'size'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
