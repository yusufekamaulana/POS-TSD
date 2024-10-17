<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_name',
        'price',
        'category_id',
        'quantity_in_stock',
        'gambar',
        'harga_beli',
        'harga_jual',
        'deskripsi',
    ];

    // A product belongs to a category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    // A product has one stock record
    public function stock()
    {
        return $this->hasOne(Stock::class, 'product_id', 'product_id');
    }

    // A product can appear in many order details
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'product_id', 'product_id');
    }
}
