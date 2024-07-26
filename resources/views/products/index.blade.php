<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Products</title>
    <style>
        .center-image {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center mb-4">Products</h1>

    <form action="{{ route('products.index') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-4 mb-3">
                <input type="text" name="name" class="form-control" placeholder="Search by name"
                       value="{{ request('name') }}">
            </div>
            <div class="col-md-4 mb-3">
                <select name="category_id" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option
                            value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div class="col-md-2 mb-3 text-end">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>

            <div class="col-md-4 mb-3">
                <a href="{{ route('order.create') }}" class="btn btn-secondary">Place Order</a>
                <a href="{{route('category.create')}}" style="display: inline; margin-left: 10px" class="mb-5 btn btn-success">Add Category</a>
                <a href="{{route('products.create')}}" style="display: inline; margin-left: 10px" class="mb-5 btn btn-outline-warning">Add Product</a>

            </div>

        </div>
    </form>

    @foreach($products as $product)
        <div class="card mb-3">
            <div class="row g-0">
                <div class="col-md-4 center-image">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded-start"
                             alt="{{ $product->name }}" height="180" width="250">
                    @else
                        <img src="https://via.placeholder.com/150" class="img-fluid rounded-start"
                             alt="{{ $product->name }}">
                    @endif
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <p class="card-text"><small class="text-muted">Price: {{ $product->price }} EGP</small></p>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary">View Details</a>

                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <div class="d-flex justify-content-center">
        {{ $products->links('pagination::bootstrap-4') }}
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
