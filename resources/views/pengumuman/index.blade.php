@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h2">{{ __('messages.announcement') }}</h1>
            <a href="{{ route('pengumuman.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> {{ __('messages.add_announcement') }}
</a>

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
                            <th>{{ __('messages.thumbnail') }}</th>
                            <th>{{ __('messages.title') }}</th>
                            <th>{{ __('messages.effective_start') }}</th>
                            <th>{{ __('messages.effective_end') }}</th>
                            <th>{{ __('messages.created_by') }}</th>
                            <th>{{ __('messages.action') }}</th>
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

                                <td>{{ $item->efficient_start_date ? \Carbon\Carbon::parse($item->efficient_start_date)->format('d-m-Y') : '-' }}
                                </td>
                                <td>{{ $item->efficient_end_date ? \Carbon\Carbon::parse($item->efficient_end_date)->format('d-m-Y') : '-' }}
                                </td>



                                <td>{{ $item->creator->name ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('pengumuman.show', $item) }}" class="btn btn-sm btn-primary"><i
                                            class="fas fa-eye"></i> Lihat</a>
                                    <a href="{{ route('pengumuman.edit', $item) }}" class="btn btn-sm btn-warning"><i
                                            class="fas fa-edit"></i> Edit</a>
                                    <form action="{{ route('pengumuman.destroy', $item) }}" method="POST"
                                        style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Hapus pengumuman ini?')"><i class="fas fa-trash"></i>
                                            Hapus</button>
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
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#pengumuman-table').DataTable();
        });
    </script>

    <link href="{{ asset('css/pengumuman.css') }}" rel="stylesheet">
@endpush
