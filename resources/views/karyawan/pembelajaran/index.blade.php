@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h2">{{ __('messages.learning_center') }}</h1>

        </div>
        <hr class="mb-3" />
        <div class="card shadow">
            <div class="card-body">
                <table id="pembelajaran-table" class="table table-bordered table-hover table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>{{ __('messages.thumbnail') }}</th>
                            <th>{{ __('messages.title') }}</th>
                            <th>{{ __('messages.description') }}</th>
                            <th>{{ __('messages.created_by') }}</th>
                            <th>{{ __('messages.created_at') }}</th>
                            <th>{{ __('messages.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
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
                                <td>{{ \Illuminate\Support\Str::limit($item->deskripsi, 50) }}</td>
                                <td>{{ $item->creator->name ?? '-' }}</td>
                                <td>{{ $item->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('karyawan.pembelajaran.show', $item) }}"
                                        class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i> {{ __('messages.show') }}
                                    </a>

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
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#pembelajaran-table').DataTable();
        });
    </script>
@endpush
