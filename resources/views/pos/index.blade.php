<!-- resources/views/pos.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Point of Sale</h2>
            <div class="form-group">
                <input type="text" id="productSearch" class="form-control" placeholder="Search product by name or scan barcode" autofocus>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="cartItems">
                    <!-- Cart items will be appended here dynamically -->
                </tbody>
            </table>
            <div class="form-group">
                <button id="processSale" class="btn btn-primary">Process Sale</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const productSearch = document.getElementById('productSearch');
        const cartItems = document.getElementById('cartItems');

        productSearch.addEventListener('keyup', function (e) {
            if (e.key === 'Enter') {
                const query = productSearch.value.trim();
                if (query) {
                    fetchProduct(query);
                }
            }
        });

        function fetchProduct(query) {
            fetch(`/api/products/search?query=${query}`)
                .then(response => response.json())
                .then(data => {
                    if (data.product) {
                        addToCart(data.product);
                    } else {
                        alert('Product not found');
                    }
                });
        }

        function addToCart(product) {
            let cartItem = document.querySelector(`#cartItems tr[data-id="${product.id}"]`);
            if (cartItem) {
                let quantity = cartItem.querySelector('.quantity');
                quantity.value = parseInt(quantity.value) + 1;
                updateCartItem(cartItem, product.price);
            } else {
                cartItem = document.createElement('tr');
                cartItem.setAttribute('data-id', product.id);
                cartItem.innerHTML = `
                    <td>${product.name}</td>
                    <td><input type="number" class="quantity" value="1" min="1"></td>
                    <td>${product.price}</td>
                    <td class="item-total">${product.price}</td>
                    <td><button class="btn btn-danger remove-item">Remove</button></td>
                `;
                cartItems.appendChild(cartItem);
                cartItem.querySelector('.quantity').addEventListener('change', function () {
                    updateCartItem(cartItem, product.price);
                });
                cartItem.querySelector('.remove-item').addEventListener('click', function () {
                    cartItem.remove();
                    updateTotal();
                });
            }
            updateTotal();
        }

        function updateCartItem(cartItem, price) {
            const quantity = cartItem.querySelector('.quantity').value;
            const itemTotal = cartItem.querySelector('.item-total');
            itemTotal.textContent = (quantity * price).toFixed(2);
            updateTotal();
        }

        function updateTotal() {
            let total = 0;
            cartItems.querySelectorAll('tr').forEach(cartItem => {
                total += parseFloat(cartItem.querySelector('.item-total').textContent);
            });
            document.getElementById('total').textContent = total.toFixed(2);
        }

        document.getElementById('processSale').addEventListener('click', function () {
            const saleItems = [];
            cartItems.querySelectorAll('tr').forEach(cartItem => {
                saleItems.push({
                    product_id: cartItem.getAttribute('data-id'),
                    quantity: cartItem.querySelector('.quantity').value,
                    price: cartItem.querySelector('.item-total').textContent
                });
            });
            processSale(saleItems);
        });

        function processSale(saleItems) {
            fetch('/api/sales', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ saleItems })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Sale processed successfully');
                        cartItems.innerHTML = '';
                        updateTotal();
                        productSearch.value = '';
                    } else {
                        alert('Failed to process sale');
                    }
                });
        }
    });
</script>
@endsection
