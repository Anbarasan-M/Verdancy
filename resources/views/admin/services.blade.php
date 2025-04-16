@extends('layouts.common_layout')

@section('content')
<div class="container">
    <h1 class="mb-4">Services</h1>

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Actions</th> <!-- New Actions Column -->
            </tr>
        </thead>
        <tbody>
            @foreach ($services as $service)
            <tr>
                <td>
                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="img-thumbnail" style="width: 80px; height: 80px;">
                </td>
                <td>{{ $service->name }}</td>
                <td>{{ $service->description }}</td>
                <td>${{ number_format($service->price, 2) }}</td>
                <td>
                    <a href="{{ route('services.edit', $service->id) }}" class="btn btn-primary btn-sm">Edit</a> <!-- Edit Button -->
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
