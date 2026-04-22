<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserRating extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'rating','rate_datetime'];


    public function users(){
        return $this->belongsTo(User::class);
    }

    public function products(){
        return $this->belongsTo(Product::class);
    }
}
