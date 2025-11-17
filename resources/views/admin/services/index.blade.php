@extends('layouts.app')

@section('title', 'Kelola Layanan')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1>Kelola Layanan</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.services.create') }}" class="btn btn-primary">Tambah Layanan</a>
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
                @if($services->count() > 0)
                    Menampilkan {{ $services->firstItem() }} - {{ $services->lastItem() }} dari <strong>{{ $services->total() }}</strong> layanan
                @else
                    Tidak ada layanan
                @endif
            </span>
        </div>
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Icon</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($services as $service)
                        <tr>
                            <td>{{ $service->id }}</td>
                            <td>{{ $service->name }}</td>
                            <td><i class="{{ $service->icon }}"></i> <code>{{ $service->icon }}</code></td>
                            <td>{{ Str::limit($service->description, 50) }}</td>
                            <td>
                                <a href="{{ route('admin.services.show', $service) }}" class="btn btn-sm btn-info">Lihat</a>
                                <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form method="POST" action="{{ route('admin.services.destroy', $service) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Tidak ada layanan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($services->hasPages())
        <div class="mt-4">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    {{-- Previous Page Link --}}
                    @if ($services->onFirstPage())
                        <li class="page-item disabled"><span class="page-link bg-light">← Sebelumnya</span></li>
                    @else
                        <li class="page-item"><a class="page-link btn-warning" href="{{ $services->previousPageUrl() }}">← Sebelumnya</a></li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($services->getUrlRange(1, $services->lastPage()) as $page => $url)
                        @if ($page == $services->currentPage())
                            <li class="page-item active"><span class="page-link btn-warning">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link btn-warning" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($services->hasMorePages())
                        <li class="page-item"><a class="page-link btn-warning" href="{{ $services->nextPageUrl() }}">Selanjutnya →</a></li>
                    @else
                        <li class="page-item disabled"><span class="page-link bg-light">Selanjutnya →</span></li>
                    @endif
                </ul>
            </nav>
        </div>
    @endif
</div>
@endsection
