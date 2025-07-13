@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h2">Manajemen Persetujuan Pengguna</h1>
    </div>
    <hr class="mb-3" />
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table id="usersTable" class="table table-bordered table-hover table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Departemen</th>
                            <th>Role</th>
                            <th>Tanggal Registrasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingUsers as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->departement }}</td>
                            <td>{{ ucfirst($user->role) }}</td>
                            {{-- <td>{{ $user->created_at->format('d/m/Y H:i') }}</td> --}}
                            <td>{{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : '-' }}</td>

                            <td>
                                <div class="btn-group">
                                    @if ($user->role == 'hrd')
                                    <a href="{{ route('user-approvals.show_hrd', $user) }}" 
                                       class="btn btn-sm btn-info" 
                                       data-toggle="tooltip" 
                                       title="Detail">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>        
                                    @else
                                    <a href="{{ route('user-approvals.show', $user) }}" 
                                       class="btn btn-sm btn-info" 
                                       data-toggle="tooltip" 
                                       title="Detail">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>    
                                    @endif
                                    <button type="button" 
                                            class="ml-2 btn btn-sm btn-success" 
                                            onclick="approveUser({{ $user->id }})"
                                            data-toggle="tooltip"
                                            title="Setujui">
                                        <i class="fas fa-check"></i> Setujui
                                    </button>
                                    <button type="button" 
                                            class="ml-2 btn btn-sm btn-danger" 
                                            onclick="rejectUser({{ $user->id }})"
                                            data-toggle="tooltip"
                                            title="Tolak">
                                        <i class="fas fa-times"></i> Tolak
                                    </button>
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
    $(document).ready(function() {
        $('#usersTable').DataTable();
    });

    function approveUser(id) {
        if (confirm('Apakah Anda yakin ingin menyetujui pengguna ini?')) {
            $.post(`/user-approvals/${id}/approve`, {
                _token: '{{ csrf_token() }}'
            })
            .done(function() {
                location.reload();
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