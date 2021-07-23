<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $user = Auth::user();
        $product = Product::where('id', $request->product_id)->first();

        if ($request->quantity > $product->available_stock) {
            return response()->json([
                'message' => 'Failed to order this product due to unavailability of the stock'
            ], 400);
        }

        $user->orders()->create($request->only(['user_id', 'product_id', 'quantity']));
        $stock = $product->available_stock - $request->quantity;
        $product->update([
            'available_stock' => $stock
        ]);

        return response()->json([
            'message' => 'You have successfully ordered this product.'
        ], 201);
        
    }
}
