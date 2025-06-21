@extends('layouts.app')

@section('title', 'Detail Produk - Admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Detail Produk</h4>
                    <div>
                        <a href="{{ route('admin.edit', $produk->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td width="150"><strong>ID Produk:</strong></td>
                                        <td>{{ $produk->id }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Nama Produk:</strong></td>
                                        <td>{{ $produk->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Deskripsi:</strong></td>
                                        <td>{{ $produk->deskripsi }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Harga:</strong></td>
                                        <td>
                                            <span class="h5 text-primary">
                                                Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Stok:</strong></td>
                                        <td>
                                            <span class="badge {{ $produk->stok > 10 ? 'bg-success' : ($produk->stok > 0 ? 'bg-warning' : 'bg-danger') }} fs-6">
                                                {{ $produk->stok }} unit
                                            </span>
                                            @if($produk->stok <= 5 && $produk->stok > 0)
                                                <small class="text-warning">
                                                    <i class="fas fa-exclamation-triangle"></i> Stok terbatas
                                                </small>
                                            @elseif($produk->stok == 0)
                                                <small class="text-danger">
                                                    <i class="fas fa-times-circle"></i> Stok habis
                                                </small>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status:</strong></td>
                                        <td>
                                            @if($produk->stok > 0)
                                                <span class="badge bg-success">Tersedia</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Tersedia</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Dibuat pada:</strong></td>
                                        <td>{{ $produk->created_at ? $produk->created_at->format('d F Y, H:i') : '-' }}</td>
                                    </tr>
                                    @if($produk->updated_at && $produk->updated_at != $produk->created_at)
                                    <tr>
                                        <td><strong>Terakhir diupdate:</strong></td>
                                        <td>{{ $produk->updated_at->format('d F Y, H:i') }}</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <div>
                        <a href="{{ route('admin.edit', $produk->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Produk
                        </a>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash"></i> Hapus Produk
                        </button>
                    </div>
                    <div>
                        <a href="{{ route('admin.index') }}" class="btn btn-secondary">
                            <i class="fas fa-list"></i> Daftar Produk
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Peringatan!</strong> Tindakan ini tidak dapat dibatalkan.
                </div>
                <p>Apakah Anda yakin ingin menghapus produk berikut?</p>
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">{{ $produk->nama }}</h6>
                        <p class="card-text">{{ Str::limit($produk->deskripsi, 100) }}</p>
                        <small class="text-muted">Harga: Rp {{ number_format($produk->harga, 0, ',', '.') }}</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Batal
                </button>
                <form action="{{ route('admin.delete', $produk->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Ya, Hapus Produk
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection