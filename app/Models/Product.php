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
        'price',
        'category_id',
        'quantity_in_stock',
        'gambar',
        'harga_beli',
        'harga_jual',
        'deskripsi',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            // Format product_id
            $date = now()->format('ymd');
            $lastProduct = self::whereDate('created_at', today())->orderBy('product_id', 'desc')->first();
            $lastNumber = $lastProduct ? (int) substr($lastProduct->product_id, -3) : 0;
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            $product->product_id = $date . $newNumber;

            // Barcode Text
            $barcodeText = $product->product_id;
            $barcodeWidth = 140;  // Width for the barcode (16:9 ratio width)
            $barcodeHeight = 90;  // Height for the barcode (16:9 ratio height)
            $barcodePath = 'barcodes/' . $product->product_id . '.png';

            // Create instance of DNS1D
            $barcode = new DNS1D();

            // Generate barcode as PNG string in base64 format
            $barcodeBase64 = $barcode->getBarcodePNG($barcodeText, 'C128', 3, 50, [0, 0, 0], true);  

            // Decode the base64 string to binary image data
            $barcodeImageData = base64_decode($barcodeBase64);

            if ($barcodeImageData === false) {
                throw new \Exception("Failed to decode base64 barcode image.");
            }

            // Create a new image resource with desired 16:9 aspect ratio
            $image = imagecreate($barcodeWidth, $barcodeHeight);

            // Set background color to white
            $backgroundColor = imagecolorallocate($image, 255, 255, 255);
            imagefill($image, 0, 0, $backgroundColor);

            // Load the decoded barcode PNG image into an image resource
            $barcodeImageResource = imagecreatefromstring($barcodeImageData);

            if (!$barcodeImageResource) {
                throw new \Exception("Failed to create image from barcode string.");
            }

            // Center barcode image in the 16:9 canvas
            $barcodeX = ($barcodeWidth - imagesx($barcodeImageResource)) / 2;
            $barcodeY = ($barcodeHeight - imagesy($barcodeImageResource)) / 2;
            imagecopy($image, $barcodeImageResource, $barcodeX, $barcodeY, 0, 0, imagesx($barcodeImageResource), imagesy($barcodeImageResource));

            // Save final image with barcode only
            imagepng($image, public_path($barcodePath));
            imagedestroy($image);  // Free up memory

            // Save barcode path to the product record
            $product->barcode_image = $barcodePath;
        });
    }

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
