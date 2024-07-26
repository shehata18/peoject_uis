<?php

namespace App\Http\Controllers\Api;

use App\Events\OrderStatusUpdated;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Services\WebhookNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    protected $webhookNotificationService;

    public function __construct(WebhookNotificationService $webhookNotificationService)
    {
        $this->webhookNotificationService = $webhookNotificationService;
    }


    /**
     * @OA\Post(
     *     path="/api/orders",
     *     summary="Create a new order",
     *     tags={"Orders"},
     *     security={{"apiAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="product_id", type="integer", example=1),
     *             @OA\Property(property="quantity", type="integer", example=2),
     *             @OA\Property(property="phone", type="string", example="123-456-7890")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Order placed successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="string", example="Order placed successfully!"),
     *             @OA\Property(property="order", ref="#/components/schemas/Order")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */

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
            'phone' => $request->phone,
        ]);

        $order->products()->attach($product->id, [
            'quantity' => $request->quantity,
            'total_price' => $totalPrice,
        ]);

        return response()->json([
            'success' => 'Order placed successfully!',
            'order' => $order->load('products'),
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/orders/{order}",
     *     summary="Update order status",
     *     tags={"Orders"},
     *     security={{"apiAuth":{}}},
     *     @OA\Parameter(
     *         name="order",
     *         in="path",
     *         description="ID of the order",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="shipped")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order status updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Order status updated successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Order not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|string',
        ]);

        $order = Order::find($id);
        if ($order) {
            $order->status = $validated['status'];
            $order->save();

            // Fire the event
            event(new OrderStatusUpdated($order->id, $order->status));

            return response()->json(['message' => 'Order status updated successfully']);
        }

        return response()->json(['message' => 'Order not found'], 404);
    }

    /**
     * @OA\Get(
     *     path="/api/orders",
     *     summary="Get user's orders",
     *     tags={"Orders"},
     *     security={{"apiAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="order_id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="user_name", type="string", example="John Doe"),
     *                 @OA\Property(property="status", type="string", example="pending"),
     *                 @OA\Property(
     *                     property="products",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="category_name", type="string", example="Electronics"),
     *                         @OA\Property(property="product_name", type="string", example="Smartphone"),
     *                         @OA\Property(property="description", type="string", example="A high-end smartphone"),
     *                         @OA\Property(property="image", type="string", example="https://example.com/image.jpg"),
     *                         @OA\Property(property="price", type="number", format="float", example=699.99),
     *                         @OA\Property(property="quantity", type="integer", example=2),
     *                         @OA\Property(property="total_price", type="number", format="float", example=1399.98)
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function getUserOrders()
    {
        $user = Auth::user();
        $orders = $user->orders()->with(['products.category'])->get();

        $orders = $orders->map(function ($order) {
            return [
                'order_id' => $order->id,
                'user_id' => $order->user_id,
                'user_name' => $order->user->name,
                'status' => $order->status, // Include status at the order level
                'products' => $order->products->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'category_name' => $product->category->name,
                        'product_name' => $product->name,
                        'description' => $product->description,
                        'image' => $product->image,
                        'price' => $product->price,
                        'quantity' => $product->pivot->quantity,
                        'total_price' => $product->pivot->total_price,
                    ];
                }),
            ];
        });

        return response()->json($orders, 200);
    }
}
