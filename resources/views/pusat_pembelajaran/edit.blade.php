@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Edit Materi Pembelajaran</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('pusat_pembelajaran.update', $pusat_pembelajaran) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Judul</label>
                    <input type="text" name="judul" class="form-control" value="{{ old('judul', $pusat_pembelajaran->judul) }}" required>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi', $pusat_pembelajaran->deskripsi) }}</textarea>
                </div>
                <div class="form-group">
                    <label>Thumbnail</label><br>
                    @if($pusat_pembelajaran->thumbnail)
                        <img src="{{ asset('storage/'.$pusat_pembelajaran->thumbnail) }}" width="80" height="80" style="object-fit:cover;" class="mb-2"><br>
                    @endif
                    <input type="file" name="thumbnail" class="form-control-file">
                </div>
                <div class="form-group">
                    <label>Konten (PDF)</label><br>
                    @if($pusat_pembelajaran->konten)
                        <a href="{{ asset('storage/'.$pusat_pembelajaran->konten) }}" target="_blank" class="btn btn-sm btn-info mb-2"><i class="fas fa-file-pdf"></i> Lihat PDF Saat Ini</a><br>
                    @endif
                    <input type="file" name="konten" class="form-control-file" accept="application/pdf">
                </div>
                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('pusat_pembelajaran.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection 