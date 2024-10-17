<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;

class KasirController extends Controller
{
    public function search(Request $request)
    {
        // Get the search query
        $searchTerm = $request->get('query');

        // Search for products by product name
        $products = Product::where('product_name', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('product_id', $searchTerm)
            ->get();

        // Return the search result as JSON
        return response()->json($products);
    }

    public function prosesPembayaran(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string|in:Pembayaran Tunai,Pembayaran QRIS', // Validasi untuk payment_method
            'products' => 'required|array',
            'products.*.id' => 'required|string',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|integer',
        ]);
        

        // Get payment method and products from request
        $paymentMethod = $request->input('payment_method');
        if ($paymentMethod == 'Pembayaran Tunai') {
            $paymentMethod = 'cash';
        } elseif ($paymentMethod == 'Pembayaran QRIS') {
            $paymentMethod = 'credit_card';
        }
          
        $products = $request->input('products');

        $totalAmount = 0;

        // Process each product (e.g., save the order to the database)

        $order = Order::create([
            'order_date' => today(),
        ]);

        foreach ($products as $product) {
            // Find the product by product_id
            $idProduct = $product['id'];
            $quantityProduct = $product['quantity'];
            $priceProduct = $product['price'];

            $existingProduct = Product::where('product_id', $idProduct)->first();
    
            if ($existingProduct) {
                // Subtract the purchased quantity from the current stock
                $newStock = $existingProduct->quantity_in_stock - $quantityProduct;
    
                // Update the stock only if the new stock is not negative
                if ($newStock >= 0) {
                    $existingProduct->update(['quantity_in_stock' => $newStock]);
                } else {
                    // Handle the case where stock would go negative
                    return response()->json([
                        'success' => false,
                        'message' => 'Insufficient stock for product: ' . $existingProduct->product_name
                    ], 400); // 400 Bad Request
                }
            }

            $orderdetail = OrderDetail::create([
                'order_id' => $order->order_id,
                'product_id' => $idProduct,
                'quantity' => $quantityProduct,
                'unit_price' => $priceProduct,
            ]);

            $totalAmount += $priceProduct;

        }
        
        $payment = Payment::create([
            'order_id' => $order->order_id,
            'payment_date' => today(),
            'payment_amount' => $totalAmount,
            'payment_method' => $paymentMethod,
        ]);

        // Return a JSON response indicating success
        return response()->json(['success' => true]);
    }
}
