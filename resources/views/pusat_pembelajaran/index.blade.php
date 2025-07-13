@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h2">Ruang Baca Digital</h1>
        <a href="{{ route('pusat_pembelajaran.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Materi</a>
    </div>
    <hr class="mb-3" />
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card shadow">
        <div class="card-body">
            <table id="pembelajaran-table" class="table table-bordered table-hover table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Thumbnail</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Dibuat Oleh</th>
                        <th>Dibuat Pada</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>
                            @if($item->thumbnail)
                                <img src="{{ asset('storage/'.$item->thumbnail) }}" width="60" height="60" style="object-fit:cover; border-radius:8px;">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $item->judul }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($item->deskripsi, 50) }}</td>
                        <td>{{ $item->creator->name ?? '-' }}</td>
                        <td>{{ $item->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ asset('storage/'.$item->konten) }}" download class="btn btn-sm btn-info"><i class="fas fa-file-download"></i> Download PDF</a>
                            <a href="{{ route('pusat_pembelajaran.show', $item) }}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> Show</a>
                            <a href="{{ route('pusat_pembelajaran.edit', $item) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a>                           
                            <form action="{{ route('pusat_pembelajaran.destroy', $item) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus materi ini?')"><i class="fas fa-trash"></i> Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $items->links() }}
</div>
@endsection

@push('scripts')
<!-- DataTables CSS/JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link href="{{ asset('css/pusat-pembelajaran.css') }}" rel="stylesheet">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#pembelajaran-table').DataTable();
    });
</script>
@endpush 


