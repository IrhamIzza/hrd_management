@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Tambah Materi Pembelajaran</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('pusat_pembelajaran.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Judul</label>
                    <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" required>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi') }}</textarea>
                </div>
                <div class="form-group">
                    <label>Thumbnail</label>
                    <input type="file" name="thumbnail" class="form-control-file">
                </div>
                <div class="form-group">
                    <label>Konten (PDF)</label>
                    <input type="file" name="konten" class="form-control-file" accept="application/pdf" required>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="{{ route('pusat_pembelajaran.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection 

@push('styles')
<link href="{{ asset('css/pusat-pembelajaran.css') }}" rel="stylesheet">
@endpush
