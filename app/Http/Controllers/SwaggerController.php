<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Ecommerce API Documentation ( UIS Task )",
 *     version="1.0.0",
 *     description="This is The simple enpoints for ecommerce documentation for UIS Company"
 * )
 *
 * @OA\SecurityScheme(
 * securityScheme="apiAuth",
 * type="http",
 * scheme="bearer",
 * bearerFormat="JWT"
 * )
 *
 * @OA\Components(
 *     @OA\Schema(
 *         schema="Product",
 *         type="object",
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="category_name", type="string", example="Electronics"),
 *         @OA\Property(property="product_name", type="string", example="Smartphone"),
 *         @OA\Property(property="description", type="string", example="A high-end smartphone"),
 *         @OA\Property(property="image", type="string", example="https://example.com/image.jpg"),
 *         @OA\Property(property="price", type="number", format="float", example=699.99),
 *         @OA\Property(property="quantity", type="integer", example=2),
 *         @OA\Property(property="total_price", type="number", format="float", example=1399.98)
 *     ),
 *     @OA\Schema(
 *         schema="Order",
 *         type="object",
 *         @OA\Property(property="order_id", type="integer", example=1),
 *         @OA\Property(property="user_id", type="integer", example=1),
 *         @OA\Property(property="user_name", type="string", example="John Doe"),
 *         @OA\Property(property="status", type="string", example="pending"),
 *         @OA\Property(
 *             property="products",
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Product")
 *         )
 *     )
 * )
 */





class SwaggerController extends Controller
{
    /**
     * @OA\Schema(
     *     schema="Product",
     *     type="object",
     *     title="Product",
     *     description="Product model",
     *     properties={
     *         @OA\Property(property="id", type="integer", description="ID of the product"),
     *         @OA\Property(property="name", type="string", description="Name of the product"),
     *         @OA\Property(property="description", type="string", description="Description of the product"),
     *         @OA\Property(property="price", type="number", format="float", description="Price of the product"),
     *         // Add other properties as needed
     *     }
     * )
     */
}
