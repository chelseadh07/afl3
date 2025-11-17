@extends('layouts.app')

@section('title', 'Detail Kategori')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title mb-4">{{ $category->name }}</h2>

                    <table class="table">
                        <tr>
                            <th>Slug</th>
                            <td>{{ $category->slug }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah Produk</th>
                            <td>{{ $category->products()->count() }}</td>
                        </tr>
                        <tr>
                            <th>Dibuat</th>
                            <td>{{ $category->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>

                    <div class="mt-4">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning">Edit</a>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
