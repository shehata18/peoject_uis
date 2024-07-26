@extends('layouts.app')

@section('content')
    <div class="container">

        <h1 class="mb-6 mt-6">My Orders</h1>

        @if($orders->isEmpty())
            <p>You have no orders yet.</p>
        @else
            <table class="table">
                <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total Price</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    @foreach($order->products as $product)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->pivot->quantity }}</td>
                            <td>EGP{{ number_format($product->price, 2) }}</td>
                            <td>EGP{{ number_format($product->pivot->total_price, 2) }}</td>
                            <td>{{ $order->status }}</td>
                        </tr>
                    @endforeach
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
