@extends('layouts.app')

@section('title', 'Shop - Lumospace')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-6">
                @if(request('search'))
                    <h1>Hasil Pencarian: <strong>"{{ request('search') }}"</strong></h1>
                    <p class="text-muted">
                        <a href="{{ route('products') }}" class="link-dark">← Kembali ke semua produk</a>
                    </p>
                @else
                    <h1>Our Collection</h1>
                @endif
            </div>
            <div class="col-md-6 text-md-end">
                <small class="text-muted">
                    @if($products->count() > 0)
                        Showing {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} 
                        of {{ $products->total() }} products
                    @else
                        Tidak ada produk
                    @endif
                </small>
            </div>
        </div>

        @if($products->count() > 0)
            <div class="row g-4">
                @foreach($products as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card border-0 shadow-sm h-100 transition-transform" style="transition: transform 0.3s ease;">
                        <div style="overflow: hidden; height: 250px;">
                            <img src="{{ asset('assets/images/' . $product->image) }}" 
                                 class="card-img-top w-100" 
                                 alt="{{ $product->name }}"
                                 style="object-fit: cover; height: 100%; transition: transform 0.3s ease;">
                        </div>
                        <div class="card-body d-flex flex-column text-center">
                            <h6 class="card-title fw-bold">{{ $product->name }}</h6>
                            <p class="card-text text-muted mb-2">
                                <strong>${{ number_format($product->price, 2) }}</strong>
                            </p>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-dark btn-sm mt-auto">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination with Better Styling -->
            <div class="mt-5 d-flex justify-content-center">
                <nav aria-label="Page navigation">
                    {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                </nav>
            </div>
        @else
            <div class="alert alert-info text-center py-5">
                <h5>Produk Tidak Ditemukan</h5>
                @if(request('search'))
                    <p class="text-muted">
                        Tidak ada produk yang cocok dengan pencarian "<strong>{{ request('search') }}</strong>"
                    </p>
                    <p class="mb-0">
                        <a href="{{ route('products') }}" class="btn btn-dark btn-sm">Lihat Semua Produk</a>
                    </p>
                @else
                    <p class="text-muted">Check back later for new items!</p>
                @endif
            </div>
        @endif
    </div>
</section>

<style>
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }

    .card:hover img {
        transform: scale(1.05);
    }

    /* Pagination styling */
    .pagination {
        gap: 5px;
    }

    .pagination .page-link {
        border-radius: 5px;
        border: 1px solid #ffc107;
        padding: 8px 12px;
        color: #212529;
        font-weight: 500;
        background-color: #fff;
    }

    .pagination .page-link:hover {
        background-color: #ffc107;
        color: #212529;
        border-color: #ffc107;
    }

    .pagination .page-item.active .page-link {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #212529;
    }

    .pagination .page-item.disabled .page-link {
        color: #6c757d;
        cursor: not-allowed;
        background-color: #f8f9fa;
    }
</style>
@endsection
