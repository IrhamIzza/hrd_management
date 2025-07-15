@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                @if($pengumuman->thumbnail)
                    <img src="{{ asset('storage/'.$pengumuman->thumbnail) }}" class="card-img-top" style="object-fit:cover; max-height:350px;">
                @endif
                <div class="card-body">
                    <h1 class="card-title h3 font-weight-bold mb-3">{{ $pengumuman->judul }}</h1>
                    <div class="mb-2 text-muted mt-5">
                        <i class="fas fa-user"></i> {{ $pengumuman->creator->name ?? '-' }}
                        <span class="mx-2">|</span>
                        <i class="fas fa-calendar-alt"></i> {{ $pengumuman->created_at->format('d M Y') }}
                        @if($pengumuman->efficient_start_date || $pengumuman->efficient_end_date)
                            <span class="mx-2">|</span>
                            <i class="fas fa-clock"></i>
                            Mulai Berlaku:
                            @if($pengumuman->efficient_start_date)
                                {{ $pengumuman->efficient_start_date }}
                            @endif
                            @if($pengumuman->efficient_end_date)
                                Hingga {{ $pengumuman->efficient_end_date }}
                            @endif
                        @endif
                    </div>
                    <hr class="my-3">
                    <div class="article-content" style="font-size:1.1rem; line-height:1.7;">
                        {!! $pengumuman->deskripsi !!}
                    </div>
                </div>
            </div>
            <a href="{{ route('karyawan.pengumuman.index') }}" class="btn btn-outline-primary"><i class="fas fa-arrow-left"></i> Kembali ke Daftar Pengumuman</a>
        </div>
    </div>
</div>
@endsection 