<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Milon\Barcode\DNS1D;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';
    public $incrementing = false; // Supaya product_id tidak auto-increment

    protected $fillable = [
        'product_name',
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

    // Fungsi untuk generate barcode dalam base64
    public function getBarcodeBase64()
    {
        $barcode = new DNS1D();
        $barcodeBase64 = $barcode->getBarcodePNG($this->product_id, 'C128', 3, 50, [0, 0, 0], true);
        return $barcodeBase64;
    }
}
