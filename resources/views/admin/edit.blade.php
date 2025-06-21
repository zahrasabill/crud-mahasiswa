@extends('layouts.app')

@section('title', 'Edit Produk - Admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Edit Produk: {{ $produk->nama }}</h4>
                    <a href="{{ route('admin.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.update', $produk->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('nama') is-invalid @enderror" 
                                   id="nama" 
                                   name="nama" 
                                   value="{{ old('nama', $produk->nama) }}"
                                   placeholder="Masukkan nama produk"
                                   required>
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" 
                                      name="deskripsi" 
                                      rows="4"
                                      placeholder="Masukkan deskripsi produk"
                                      required>{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="harga" class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" 
                                               class="form-control @error('harga') is-invalid @enderror" 
                                               id="harga" 
                                               name="harga" 
                                               value="{{ old('harga', $produk->harga) }}"
                                               min="0"
                                               step="0.01"
                                               placeholder="0"
                                               required>
                                        @error('harga')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="stok" class="form-label">Stok <span class="text-danger">*</span></label>
                                    <input type="number" 
                                           class="form-control @error('stok') is-invalid @enderror" 
                                           id="stok" 
                                           name="stok" 
                                           value="{{ old('stok', $produk->stok) }}"
                                           min="0"
                                           placeholder="0"
                                           required>
                                    @error('stok')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('admin.index') }}" class="btn btn-secondary me-md-2">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Produk
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Informasi Produk -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Informasi Produk</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">ID Produk:</small><br>
                            <strong>{{ $produk->id }}</strong>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Dibuat pada:</small><br>
                            <strong>{{ $produk->created_at ? $produk->created_at->format('d/m/Y H:i') : '-' }}</strong>
                        </div>
                    </div>
                    @if($produk->updated_at && $produk->updated_at != $produk->created_at)
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <small class="text-muted">Terakhir diupdate:</small><br>
                                <strong>{{ $produk->updated_at->format('d/m/Y H:i') }}</strong>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Format input harga dengan pemisah ribuan
    document.getElementById('harga').addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, '');
        e.target.value = value;
    });
</script>
@endpush
@endsection