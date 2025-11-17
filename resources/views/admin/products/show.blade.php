@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title mb-4">{{ $product->name }}</h2>

                    @if ($product->image)
                        <div class="mb-4">
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-fluid" style="max-height: 400px; object-fit: cover;">
                        </div>
                    @endif

                    <table class="table">
                        <tr>
                            <th>Kategori</th>
                            <td>{{ $product->category->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Harga</th>
                            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Deskripsi Singkat</th>
                            <td>{{ $product->short_description }}</td>
                        </tr>
                        <tr>
                            <th>Deskripsi Lengkap</th>
                            <td>{{ $product->long_description }}</td>
                        </tr>
                        <tr>
                            <th>Dibuat</th>
                            <td>{{ $product->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>

                    <div class="mt-4">
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning">Edit</a>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
