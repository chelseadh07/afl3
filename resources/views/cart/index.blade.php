@extends('layouts.app')

@section('title', 'Keranjang Belanja - Lumospace')

@section('content')
<section class="py-5">
    <div class="container">
        <h1 class="mb-4"><i class="bi bi-cart3"></i> Keranjang Belanja</h1>

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (!$cart || $cart->items->isEmpty())
            <div class="alert alert-info text-center py-5">
                <h4 class="mb-3"><i class="bi bi-cart-x" style="font-size: 2rem;"></i></h4>
                <p class="mb-3">Keranjang Anda kosong</p>
                <a href="{{ route('products') }}" class="btn btn-warning">Lanjutkan Berbelanja</a>
            </div>
        @else
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-warning">
                                        <tr>
                                            <th>Produk</th>
                                            <th>Harga</th>
                                            <th>Jumlah</th>
                                            <th>Total</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cart->items as $item)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('products.show', $item->product) }}" class="text-decoration-none">
                                                        <strong>{{ $item->product->name }}</strong>
                                                    </a>
                                                </td>
                                                <td>${{ number_format($item->price, 2) }}</td>
                                                <td>
                                                    <form method="POST" action="{{ route('cart.update', $item) }}" style="display: inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="input-group input-group-sm" style="width: 100px;">
                                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="100" class="form-control text-center">
                                                            <button type="submit" class="btn btn-outline-warning btn-sm">✓</button>
                                                        </div>
                                                    </form>
                                                </td>
                                                <td>
                                                    <strong>${{ number_format($item->price * $item->quantity, 2) }}</strong>
                                                </td>
                                                <td>
                                                    <form method="POST" action="{{ route('cart.remove', $item) }}" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus item ini?')">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('products') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Lanjutkan Berbelanja
                        </a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Ringkasan Pesanan</h5>
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <span>${{ number_format($cart->total_price, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Ongkos Kirim:</span>
                                    <span>Gratis</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <strong>Total:</strong>
                                    <strong class="text-warning" style="font-size: 1.2rem;">${{ number_format($cart->total_price, 2) }}</strong>
                                </div>
                            </div>

                            <a href="{{ route('service') }}" class="btn btn-warning fw-bold w-100 mb-2">
                                <i class="bi bi-credit-card"></i> Lanjut ke Checkout
                            </a>

                            <form method="POST" action="{{ route('cart.clear') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger w-100" onclick="return confirm('Yakin kosongkan keranjang?')">
                                    <i class="bi bi-trash"></i> Kosongkan Keranjang
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
