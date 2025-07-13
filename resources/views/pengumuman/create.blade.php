@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Buat Pengumuman Baru</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('pengumuman.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Judul</label>
                    <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" required>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="6">{{ old('deskripsi') }}</textarea>
                </div>
                <div class="form-group">
                    <label>Thumbnail</label>
                    <input type="file" name="thumbnail" class="form-control-file">
                </div>
                <div class="form-group">
                    <label>Efficient Start Date</label>
                    <input type="date" name="efficient_start_date" class="form-control" value="{{ old('efficient_start_date') }}">
                </div>
                <div class="form-group">
                    <label>Efficient End Date</label>
                    <input type="date" name="efficient_end_date" class="form-control" value="{{ old('efficient_end_date') }}">
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="{{ route('pengumuman.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Summernote WYSIWYG -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#deskripsi').summernote({
            height: 200,
            callbacks: {
                onImageUpload: function(files) {
                    let data = new FormData();
                    data.append('file', files[0]);
                    data.append('_token', '{{ csrf_token() }}');
                    $.ajax({
                        url: '{{ route('pengumuman.upload-image') }}',
                        method: 'POST',
                        data: data,
                        contentType: false,
                        processData: false,
                        success: function(url) {
                            $('#deskripsi').summernote('insertImage', url);
                        },
                        error: function() {
                            alert('Image upload failed.');
                        }
                    });
                }
            }
        });
    });
</script>
@endpush 