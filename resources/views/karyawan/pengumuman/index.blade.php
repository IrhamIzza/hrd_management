@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h2">Pengumuman</h1>
            <a href="{{ route('karyawan.pengumuman.archived') }}" class="btn btn-secondary"><i class="fas fa-archive"></i>
                Arsip Pengumuman</a>
        </div>
        <hr class="mb-3" />
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="card shadow">
            <div class="card-body">
                <table id="pengumuman-table" class="table table-bordered table-hover table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Thumbnail</th>
                            <th>Judul</th>
                            <th>Eff. Start</th>
                            <th>Eff. End</th>
                            <th>Dibuat Oleh</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengumuman as $item)
                            <tr>
                                <td>
                                    @if ($item->thumbnail)
                                        <img src="{{ asset('storage/' . $item->thumbnail) }}" width="60" height="60"
                                            style="object-fit:cover; border-radius:8px;">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $item->judul }}</td>
                                <td>{{ $item->efficient_start_date ?? '-' }}</td>
                                <td>{{ $item->efficient_end_date ?? '-' }}</td>
                                <td>{{ $item->creator->name ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('karyawan.pengumuman.show', $item) }}"
                                        class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> Lihat</a>
                                    <form action="{{ route('karyawan.pengumuman.archive', $item) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        <button class="btn btn-sm btn-warning"
                                            onclick="return confirm('Arsipkan pengumuman ini?')"><i
                                                class="fas fa-archive"></i> Arsipkan</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- DataTables CSS/JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link href="{{ asset('css/pengumuman.css') }}" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#pengumuman-table').DataTable();
        });
    </script>
@endpush
