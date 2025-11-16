@extends('layouts.app')

@section('title', $product->name . ' - Lumospace')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-md-6">
                <img src="{{ asset('assets/images/' . $product->image) }}" class="img-fluid rounded shadow" alt="{{ $product->name }}" style="max-height: 500px; object-fit: cover;">
            </div>
            <div class="col-md-6">
                <h2 class="mb-2">{{ $product->name }}</h2>
                <p class="text-warning fw-bold mb-3" style="font-size: 1.5rem;">${{ number_format($product->price, 2) }}</p>
                <p class="text-muted mb-4">{{ $product->description }}</p>
                <p class="mb-4">{{ $product->long_description }}</p>

                @auth
                    @if(Auth::user()->role !== 'admin')
                        <!-- Add to Cart Form -->
                        <form action="{{ route('cart.add') }}" method="POST" class="mb-4">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            
                            <div class="mb-3">
                                <label for="quantity" class="form-label fw-bold">Quantity:</label>
                                <div class="input-group" style="width: 120px;">
                                    <button type="button" class="btn btn-outline-secondary" onclick="decreaseQty()">−</button>
                                    <input type="number" id="quantity" name="quantity" class="form-control text-center" value="1" min="1" max="100">
                                    <button type="button" class="btn btn-outline-secondary" onclick="increaseQty()">+</button>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-warning fw-bold px-5 py-2">
                                <i class="bi bi-cart-plus"></i> Add to Cart
                            </button>
                        </form>
                    @endif
                @else
                    <div class="alert alert-info mb-4">
                        <i class="bi bi-info-circle"></i> 
                        <a href="{{ route('auth.login') }}" class="alert-link">Login</a> untuk membeli produk ini
                    </div>
                @endauth

                <!-- Product Info -->
                <div class="card mt-5 border-0 bg-light">
                    <div class="card-body">
                        <h5 class="card-title">Informasi Produk</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><strong>Kategori:</strong> {{ $product->category->name ?? 'N/A' }}</li>
                            <li class="mb-2"><strong>Harga:</strong> ${{ number_format($product->price, 2) }}</li>
                            <li><strong>Stok:</strong> <span class="badge bg-success">Tersedia</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function decreaseQty() {
        const qty = document.getElementById('quantity');
        if (qty.value > 1) {
            qty.value = parseInt(qty.value) - 1;
        }
    }

    function increaseQty() {
        const qty = document.getElementById('quantity');
        if (qty.value < 100) {
            qty.value = parseInt(qty.value) + 1;
        }
    }
</script>
@endsection
