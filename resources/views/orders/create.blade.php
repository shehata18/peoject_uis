
<!DOCTYPE html>
<html>
<head>
    <title>Create Order</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <a href="{{route('products.index')}}"  class="mb-5 btn btn-secondary">Products</a>
    <a href="{{route('orders.index')}}"  class="ml-30 mb-5 btn btn-success">My Orders</a>

    <h1>Create Order</h1>


    <!-- Display success message -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        <div>
            <p><strong>Product Name:</strong> {{ session('product_name') }}</p>
            <p><strong>Product Price:</strong> ${{ session('product_price') }}</p>
            <p><strong>Quantity:</strong> {{ session('quantity') }}</p>
            <p><strong>Total Price:</strong> ${{ session('total_price') }}</p>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('order.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="product_id">Select Product:</label>
            <select name="product_id" id="product_id" class="form-control" required>
                <option value="">-- Select Product --</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }} - ${{ $product->price }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone Number:</label>
            <input type="text" name="phone" id="phone" class="form-control" required maxlength="20">
        </div>

        <button type="submit" class="btn btn-primary">Place Order</button>
    </form>
</div>
</body>
</html>
