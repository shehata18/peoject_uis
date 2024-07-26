<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        // Fetch orders for the authenticated user with product details
        $orders = Order::with('products')->where('user_id', Auth::id())->get();

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $products = Product::all();
        return view('orders.create',compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'phone' => 'required|string|max:20',
        ]);

        $product = Product::find($request->product_id);
        $totalPrice = $product->price * $request->quantity;

        $order = Order::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'phone' => $request->phone,
        ]);

        $order->products()->attach($product->id, [
            'quantity' => $request->quantity,
            'total_price' => $totalPrice,
        ]);
        return redirect()->route('order.create')->with([
            'success' => 'Order placed successfully!',
            'product_name' => $product->name,
            'product_price' => $product->price,
            'quantity' => $request->quantity,
            'total_price' => $totalPrice
        ]);

    }
}
