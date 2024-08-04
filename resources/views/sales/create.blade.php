<!-- resources/views/sales/create.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>New Sale</h1>
    <form action="{{ route('sales.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="discount">Discount</label>
            <input type="text" name="discount" class="form-control" value="0">
        </div>
        <div id="product-list">
            <div class="form-group">
                <label for="product_id">Product</label>
                <select name="products[0][product_id]" class="form-control">
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
                <label for="quantity">Quantity</label>
                <input type="number" name="products[0][quantity]" class="form-control" value="1">
            </div>
        </div>
        <button type="button" id="add-product" class="btn btn-secondary">Add Product</button>
        <button type="submit" class="btn btn-primary">Complete Sale</button>
    </form>

    <script>
        document.getElementById('add-product').addEventListener('click', function () {
            const productList = document.getElementById('product-list');
            const productCount = productList.children.length;
            const newProduct = productList.children[0].cloneNode(true);

            newProduct.querySelector('select').name = `products[${productCount}][product_id]`;
            newProduct.querySelector('input[name$="[quantity]"]').name = `products[${productCount}][quantity]`;
            newProduct.querySelector('input[name$="[quantity]"]').value = 1;

            productList.appendChild(newProduct);
        });
    </script>
@endsection
