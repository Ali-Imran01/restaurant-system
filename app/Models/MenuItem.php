<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\BelongsToTenant;

class MenuItem extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = ['restaurant_id', 'category_id', 'name', 'description', 'price', 'is_available', 'image_url'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
