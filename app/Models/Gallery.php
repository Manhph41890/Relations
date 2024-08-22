<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    public $fillable = [
        'product_id',
        'image_path',
    ];
    public function products()
    {
        return $this->hasOne(Product::class);
    }
}