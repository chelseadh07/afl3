@extends('layouts.app')

@section('title', 'Kelola Kategori')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1>Kelola Kategori</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Tambah Kategori</a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <span class="text-muted small">
                @if($categories->count() > 0)
                    Menampilkan {{ $categories->firstItem() }} - {{ $categories->lastItem() }} dari <strong>{{ $categories->total() }}</strong> kategori
                @else
                    Tidak ada kategori
                @endif
            </span>
        </div>
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Slug</th>
                        <th>Jumlah Produk</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td><code>{{ $category->slug }}</code></td>
                            <td><span class="badge bg-info">{{ $category->products_count }}</span></td>
                            <td>
                                <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-sm btn-info">Lihat</a>
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Tidak ada kategori</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($categories->hasPages())
        <div class="mt-4">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    {{-- Previous Page Link --}}
                    @if ($categories->onFirstPage())
                        <li class="page-item disabled"><span class="page-link bg-light">← Sebelumnya</span></li>
                    @else
                        <li class="page-item"><a class="page-link btn-warning" href="{{ $categories->previousPageUrl() }}">← Sebelumnya</a></li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($categories->getUrlRange(1, $categories->lastPage()) as $page => $url)
                        @if ($page == $categories->currentPage())
                            <li class="page-item active"><span class="page-link btn-warning">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link btn-warning" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($categories->hasMorePages())
                        <li class="page-item"><a class="page-link btn-warning" href="{{ $categories->nextPageUrl() }}">Selanjutnya →</a></li>
                    @else
                        <li class="page-item disabled"><span class="page-link bg-light">Selanjutnya →</span></li>
                    @endif
                </ul>
            </nav>
        </div>
    @endif
</div>
@endsection
