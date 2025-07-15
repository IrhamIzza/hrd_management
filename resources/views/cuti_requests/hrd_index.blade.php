@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h2">{{ __('messages.leave_management') }}</h1>
            <a href="{{ route('cuti_requests.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> {{ __('messages.apply_leave') }}
            </a>
        </div>
        <hr class="mb-3" />

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="cutiTable" class="table table-bordered table-hover table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>{{ __('messages.employee') }}</th>
                                <th>{{ __('messages.start_date') }}</th>
                                <th>{{ __('messages.end_date') }}</th>
                                <th>{{ __('messages.duration') }}</th>
                                <th>{{ __('messages.reason') }}</th>
                                <th>{{ __('messages.status') }}</th>
                                <th>{{ __('messages.submission_date') }}</th>
                                <th>{{ __('messages.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cutiRequests as $cuti)
                                <tr>
                                    <td>{{ $cuti->user->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($cuti->start_date)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($cuti->end_date)->format('d/m/Y') }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($cuti->start_date)->diffInDays(\Carbon\Carbon::parse($cuti->end_date)) + 1 }}
                                        hari
                                    </td>
                                    <td>{{ Str::limit($cuti->reason, 50) }}</td>
                                    <td>
                                        @if ($cuti->status == 'pending')
                                            <span class="badge badge-warning p-2">Menunggu</span>
                                        @elseif($cuti->status == 'approved')
                                            <span class="badge badge-success p-2">Disetujui</span>
                                        @else
                                            <span class="badge badge-danger p-2">Ditolak</span>
                                        @endif
                                    </td>
                                    <td>{{ $cuti->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('cuti_requests.hrd_show', $cuti) }}"
                                                class="btn btn-sm btn-info" data-toggle="tooltip" title="Detail">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                            @if ($cuti->status == 'pending')
                                                <button type="button" class="ml-2 btn btn-sm btn-success"
                                                    onclick="approveRequest({{ $cuti->id }})" data-toggle="tooltip"
                                                    title="Setujui">
                                                    <i class="fas fa-check"></i> Setujui
                                                </button>
                                                <button type="button" class="ml-2 btn btn-sm btn-danger"
                                                    onclick="rejectRequest({{ $cuti->id }})" data-toggle="tooltip"
                                                    title="Tolak">
                                                    <i class="fas fa-times"></i> Tolak
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel"
        aria-hidden="true">
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

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
    <style>
        .badge {
            font-size: 0.85em;
        }

        .btn-group {
            display: flex;
            gap: 5px;
        }

        .btn-group .btn {
            padding: 0.25rem 0.5rem;
        }
    </style>
@endpush

@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#cutiTable').DataTable();
        });

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
@endpush
