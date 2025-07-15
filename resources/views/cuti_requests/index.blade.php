@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">

            <h1 class="h2">{{ __('messages.leave_requests') }}</h1>
            <a href="{{ route('cuti_requests.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> {{ __('messages.submit_leave') }}
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
                                <th>{{ __('messages.no') }}</th>
                                <th>{{ __('messages.start_date') }}</th>
                                <th>{{ __('messages.end_date') }}</th>
                                <th>{{ __('messages.duration') }}</th>
                                <th>{{ __('messages.reason') }}</th>
                                <th>{{ __('messages.status') }}</th>
                                <th>{{ __('messages.submitted_at') }}</th>
                                <th>{{ __('messages.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cutiRequests as $index => $cuti)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($cuti->start_date)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($cuti->end_date)->format('d/m/Y') }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($cuti->start_date)->diffInDays(\Carbon\Carbon::parse($cuti->end_date)) + 1 }}
                                        hari
                                    </td>
                                    <td>{{ Str::limit($cuti->reason, 50) }}</td>
                                    <td>
                                        @if ($cuti->status == 'pending')
                                            <span class="badge badge-warning p-2">{{ __('messages.pending') }}</span>
                                        @elseif($cuti->status == 'approved')
                                            <span class="badge badge-success p-2">{{ __('messages.approved') }}</span>
                                        @else
                                            <span class="badge badge-danger p-2">{{ __('messages.rejected') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $cuti->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('cuti_requests.show', $cuti) }}" class="btn btn-sm btn-info"
                                                data-toggle="tooltip" title="{{ __('messages.detail') }}">
                                                <i class="fas fa-eye"></i> {{ __('messages.detail') }}
                                            </a>
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
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
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
    </script>
@endpush
