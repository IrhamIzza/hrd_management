@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="h2">Detail Pengajuan Cuti</h1>
        </div>
        <div class="col-sm-6">
            <div class="float-sm-right">
                <a href="{{ route('cuti_requests.hrd_index') }}" class="btn btn-secondary">
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
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 200px">Karyawan</th>
                        <td>{{ $cutiRequest->user->name }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Mulai</th>
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

        @if($cutiRequest->status == 'pending')
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><strong>Aksi</strong></h3>
                        </div>
                        <div class="card-body">
                            <button type="button" class="btn btn-success" onclick="approveRequest({{ $cutiRequest->id }})">
                                <i class="fas fa-check"></i> Setujui
                            </button>
                            <button type="button" class="btn btn-danger" onclick="rejectRequest({{ $cutiRequest->id }})">
                                <i class="fas fa-times"></i> Tolak
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="rejectModalLabel">Tolak Pengajuan Cuti</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="rejection_reason" style="font-weight: 400;">Alasan Penolakan</label>
                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function approveRequest(id) {
        if (confirm('Apakah Anda yakin ingin menyetujui pengajuan cuti ini?')) {
            $.post(`/cuti-requests/${id}/approve`, {
                _token: '{{ csrf_token() }}'
            })
            .done(function() {
                location.reload();
            })
            .fail(function() {
                alert('Terjadi kesalahan saat menyetujui pengajuan cuti.');
            });
        }
    }

    function rejectRequest(id) {
        $('#rejectForm').attr('action', `/cuti-requests/${id}/reject`);
        $('#rejectModal').modal('show');
    }
</script>

@push('styles')
<style>
    .btn-primary-custom {
        background-color: #005daf;
        border-color: #005daf;
        color: white;
    }

    .btn-primary-custom:hover {
        background-color: #004a9e;
        border-color: #004a9e;
    }

    .btn-secondary {
        background-color: #CAF4FF;
        border-color: #CAF4FF;
        color: #005daf;
    }

    .btn-secondary:hover {
        background-color: #b3ecff;
        border-color: #b3ecff;
        color: #004a9e;
    }

    .bg-light {
        background-color: #CAF4FF !important;
    }

    .badge-warning {
        background-color: #ffc107;
        color: black;
    }

    .badge-success {
        background-color: #28a745;
    }

    .badge-danger {
        background-color: #dc3545;
    }

    .card-title {
        color: #005daf;
    }

    .modal-header {
        background-color: #CAF4FF;
    }

    .modal-title {
        color: #005daf;
    }

    .table th {
        background-color: #005daf;
        color: white;
    }

    .table td {
        background-color: #f0faff;
    }
</style>
@endpush

@endpush 