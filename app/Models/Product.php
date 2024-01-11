<?php

namespace App\Models;

use App\Models\{Order, Review, User};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'user_id',
        'product_name',
        'stock',
        'price',
        'discount',
        'orientation',
        'description',
        'image',
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}

}
