@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Order</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            <div class="alert alert-info">
                <p>Product Name: {{ session('product_name') }}</p>
                <p>Product Price: ${{ number_format(session('product_price'), 2) }}</p>
                <p>Quantity: {{ session('quantity') }}</p>
                <p>Total Price: ${{ number_format(session('total_price'), 2) }}</p>
            </div>
        @endif

        <form action="{{ route('order.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="product_id">Product</label>
                <select name="product_id" class="form-control" required>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Place Order</button>
        </form>
    </div>
@endsection
