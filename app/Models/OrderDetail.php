<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    // Specify the table name (optional if Laravel naming convention is followed)
    protected $table = 'order_details';

    // Specify the primary key if different from 'id'
    protected $primaryKey = 'order_detail_id';

    // Define fillable columns
    protected $fillable = ['order_id', 'product_id', 'quantity', 'unit_price'];

    // Relationship to the Order model
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    // Relationship to the Product model
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
