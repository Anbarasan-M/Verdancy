@extends('layouts.common_layout')

@section('content')
<div class="container">
    <h1 class="mb-4">Stocks</h1>
    
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th> <!-- Add Actions Column -->
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>
                    <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="img-thumbnail" style="width: 80px; height: 80px;">
                </td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name ?? 'No Category' }}</td>
                <td>₹{{ number_format($product->price, 2) }}</td>
                <td>{{ $product->stock }}</td>
                <td>
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a> <!-- Edit Button -->
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
