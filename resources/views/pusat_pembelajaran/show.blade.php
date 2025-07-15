@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow mb-4">
                @if($pusat_pembelajaran->thumbnail)
                    <img src="{{ asset('storage/'.$pusat_pembelajaran->thumbnail) }}" class="card-img-top" style="object-fit:cover; max-height:350px;">
                @endif
                <div class="card-body">
                    <h1 class="card-title h3 font-weight-bold mb-3">{{ $pusat_pembelajaran->judul }}</h1>
                    <div class="mb-2 text-muted mt-5">
                        <i class="fas fa-user"></i> {{ $pusat_pembelajaran->creator->name ?? '-' }}
                        <span class="mx-2">|</span>
                        <i class="fas fa-calendar-alt"></i> {{ $pusat_pembelajaran->created_at->format('d M Y') }}
                    </div>
                    <hr class="my-3">
                    <div class="mb-3" style="font-size:1.1rem; line-height:1.7;">
                        {{ $pusat_pembelajaran->deskripsi }}
                    </div>
                    <div class="mb-3">
                        <iframe src="{{ asset('storage/'.$pusat_pembelajaran->konten) }}" width="100%" height="1200px" style="border:1px solid #ccc;"></iframe>
                    </div>
                    <a href="{{ asset('storage/'.$pusat_pembelajaran->konten) }}" download class="btn btn-info w-100"><i class="fas fa-file-download"></i> Download PDF</a>
                </div>
            </div>
            <a href="{{ route('pusat_pembelajaran.index') }}" class="btn btn-outline-primary"><i class="fas fa-arrow-left"></i> Kembali ke Daftar Materi</a>
        </div>
    </div>
</div>
@endsection 