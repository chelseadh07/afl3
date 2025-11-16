@extends('layouts.app')

@section('title', 'Detail Layanan')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title mb-4">{{ $service->name }}</h2>

                    <table class="table">
                        <tr>
                            <th>Icon</th>
                            <td><i class="{{ $service->icon }}"></i> {{ $service->icon }}</td>
                        </tr>
                        <tr>
                            <th>Deskripsi</th>
                            <td>{{ $service->description }}</td>
                        </tr>
                        <tr>
                            <th>Dibuat</th>
                            <td>{{ $service->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>

                    <div class="mt-4">
                        <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-warning">Edit</a>
                        <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
