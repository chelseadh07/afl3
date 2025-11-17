@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="mb-4">Admin Dashboard</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Produk</h5>
                    <h2>{{ \App\Models\Product::count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Total Kategori</h5>
                    <h2>{{ \App\Models\Category::count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Total Layanan</h5>
                    <h2>{{ \App\Models\Service::count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Total User</h5>
                    <h2>{{ \App\Models\User::count() }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            <h3>Menu Admin</h3>
            <div class="list-group">
                <a href="{{ route('admin.products.index') }}" class="list-group-item list-group-item-action">
                    <h5 class="mb-1">Kelola Produk</h5>
                    <p class="mb-0">Tambah, edit, atau hapus produk</p>
                </a>
                <a href="{{ route('admin.categories.index') }}" class="list-group-item list-group-item-action">
                    <h5 class="mb-1">Kelola Kategori</h5>
                    <p class="mb-0">Tambah, edit, atau hapus kategori</p>
                </a>
                <a href="{{ route('admin.services.index') }}" class="list-group-item list-group-item-action">
                    <h5 class="mb-1">Kelola Layanan</h5>
                    <p class="mb-0">Tambah, edit, atau hapus layanan</p>
                </a>
                <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action">
                    <h5 class="mb-1">Kelola User</h5>
                    <p class="mb-0">Tambah, edit, atau hapus user</p>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
