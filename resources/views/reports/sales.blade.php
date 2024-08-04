<!-- resources/views/reports/sales.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Sales Report for {{ $date }}</h2>
    <form method="get" action="{{ route('reports.sales') }}">
        <div class="form-group">
            <label for="date">Select Date:</label>
            <input type="date" id="date" name="date" value="{{ $date }}" class="form-control" onchange="this.form.submit()">
        </div>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
                @foreach($sale->saleItems as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->quantity * $item->price }}</td>
                </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        <h4>Total Sales: {{ $totalSales }}</h4>
        <h4>Total Profit: {{ $totalProfit }}</h4>
    </div>
</div>
@endsection
