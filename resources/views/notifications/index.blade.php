<!-- resources/views/notifications/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Notifications</h2>
    <h4>Low Stock Products</h4>
    <ul>
        @forelse($lowStockProducts as $product)
            <li>{{ $product->name }} - Stock: {{ $product->stock }}</li>
        @empty
            <li>No low stock products</li>
        @endforelse
    </ul>

    <h4>Expired Products</h4>
    <ul>
        @forelse($expiredProducts as $product)
            <li>{{ $product->name }} - Expiry Date: {{ $product->expiry_date }}</li>
        @empty
            <li>No expired products</li>
        @endforelse
    </ul>
</div>
@endsection
