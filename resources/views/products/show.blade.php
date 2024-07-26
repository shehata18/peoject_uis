@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">{{ $product->name }}</h1>

    <div class="card">
        <div class="card-body">
            <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded-start"
                 alt="{{ $product->name }}" height="180" width="250">
            <h5 class="card-title">Description</h5>
            <p class="card-text">{{ $product->description }}</p>

            <h5 class="card-title">Price</h5>
            <p class="card-text">{{ $product->price }} EGP</p>
            <div class="mt-3 mb-3">
                <b><p class="">Category :</p></b>
                <p class="card-text" style="background-color: lightblue; display: inline">{{ $product->category->name }}</p>
            </div>

            <a href="{{ route('products.index') }}" class="btn btn-primary">Back to List</a>
        </div>
    </div>
</div>
@endsection
