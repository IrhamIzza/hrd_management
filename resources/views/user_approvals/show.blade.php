@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h3 class="card-title">Detail Pengguna</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 200px;">Nama</th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Username</th>
                                    <td>{{ $user->username }}</td>
                                </tr>
                                <tr>
                                    <th>Departemen</th>
                                    <td>{{ $user->departement }}</td>
                                </tr>
                                <tr>
                                    <th>Role</th>
                                    <td>{{ ucfirst($user->role) }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>{{ $user->address }}</td>
                                </tr>
                                <tr>
                                    <th>Telepon</th>
                                    <td>{{ $user->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Registrasi</th>
                                    {{-- <td>{{ $user->created_at->format('d/m/Y H:i') }}</td> --}}
                                    <td>{{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : '-' }}</td>

                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($user->approval_status == 'pending')
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title"><strong>Aksi</strong></h3>
                                    </div>
                                    <div class="card-body">
                                        <button type="button" class="btn btn-success" onclick="approveUser({{ $user->id }})">
                                            <i class="fas fa-check"></i> Setujui
                                        </button>
                                        <button type="button" class="btn btn-danger" onclick="rejectUser({{ $user->id }})">
                                            <i class="fas fa-times"></i> Tolak
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="rejectModalLabel">Tolak Pengguna</h5>
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
    function approveUser(id) {
        if (confirm('Apakah Anda yakin ingin menyetujui pengguna ini?')) {
            $.post(`/user-approvals/${id}/approve`, {
                _token: '{{ csrf_token() }}'
            })
            .done(function() {
                window.location.href = '{{ route("user-approvals.index") }}';
            })
            .fail(function() {
                alert('Terjadi kesalahan saat menyetujui pengguna.');
            });
        }
    }

    function rejectUser(id) {
        $('#rejectForm').attr('action', `/user-approvals/${id}/reject`);
        $('#rejectModal').modal('show');
    }
</script>
@endpush 