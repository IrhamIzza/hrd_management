@extends('layouts.app')

@section('content')

<style>
    .btn-custom {
        background-color: #005daf;
        color: #fff;
        border: none;
    }
    .btn-custom:hover {
        background-color: #004a94;
    }

    .table th {
        background-color: #005daf;
        color: white;
    }

    .badge-warning {
        background-color: #ffc107;
    }

    .badge-success {
        background-color: #28a745;
    }

    .badge-danger {
        background-color: #dc3545;
    }

    .bg-light-custom {
        background-color: #CAF4FF;
    }

    .card {
        border: 1px solid #005daf;
    }

    .card-header {
        background-color: #005daf;
        color: #fff;
    }

    .form-group label {
        font-weight: 500;
    }
</style>

<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="h2">Detail Pengajuan Cuti</h1>
        </div>
        <div class="col-sm-6">
            <div class="float-sm-right">
                <a href="{{ route('cuti_requests.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<hr class="my-4" />
        
<div class="card">
    <div class="card-body">
        <div class="row" style="align-items: center;">
            <div class="col-md-6">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th style="width: 200px">Tanggal Mulai</th>
                        <td>{{ $cutiRequest->start_date }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Selesai</th>
                        <td>{{ $cutiRequest->end_date }}</td>
                    </tr>
                    <tr>
                        <th>Durasi</th>
                        <td>{{ \Carbon\Carbon::parse($cutiRequest->start_date)->diffInDays(\Carbon\Carbon::parse($cutiRequest->end_date)) + 1 }} hari</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($cutiRequest->status == 'pending')
                                <span class="badge badge-warning">Menunggu</span>
                            @elseif($cutiRequest->status == 'approved')
                                <span class="badge badge-success">Disetujui</span>
                            @else
                                <span class="badge badge-danger">Ditolak</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Pengajuan</th>
                        <td>{{ $cutiRequest->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Alasan Cuti</label>
                    <div class="p-3 bg-light rounded">
                        {{ $cutiRequest->reason }}
                    </div>
                </div>

                @if($cutiRequest->status == 'rejected' && $cutiRequest->rejection_reason)
                    <div class="form-group">
                        <label>Alasan Penolakan</label>
                        <div class="p-3 bg-light rounded text-danger">
                            {{ $cutiRequest->rejection_reason }}
                        </div>
                    </div>
                @endif

                @if($cutiRequest->status == 'approved')
                    <div class="form-group">
                        <label>Disetujui Oleh</label>
                        <div class="p-3 bg-light rounded">
                            {{ $cutiRequest->reviewer->name ?? 'HRD' }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Persetujuan</label>
                        <div class="p-3 bg-light rounded">
                            {{ $cutiRequest->reviewed_at }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 


@push('scripts')
<link href="{{ asset('css/pengajuan-cuti.css') }}" rel="stylesheet">

@endpush 