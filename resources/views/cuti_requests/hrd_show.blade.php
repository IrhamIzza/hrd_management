@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="h2">{{ __('messages.leave_request_detail') }}</h1>
            </div>
            <div class="col-sm-6">
                <div class="float-sm-right">
                    <a href="{{ route('cuti_requests.hrd_index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> {{ __('messages.back') }}
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
                            <th style="width: 200px">{{ __('messages.employee') }}</th>
                            <td>{{ $cutiRequest->user->name }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.start_date') }}</th>
                            <td>{{ $cutiRequest->start_date }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.end_date') }}</th>
                            <td>{{ $cutiRequest->end_date }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.duration') }}</th>
                            <td>{{ \Carbon\Carbon::parse($cutiRequest->start_date)->diffInDays(\Carbon\Carbon::parse($cutiRequest->end_date)) + 1 }}
                                {{ __('messages.days') }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.status') }}</th>
                            <td>
                                @if ($cutiRequest->status == 'pending')
                                    <span class="badge badge-warning">{{ __('messages.pending') }}</span>
                                @elseif($cutiRequest->status == 'approved')
                                    <span class="badge badge-success">{{ __('messages.approved') }}</span>
                                @else
                                    <span class="badge badge-danger">{{ __('messages.rejected') }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.submitted_at') }}</th>
                            <td>{{ $cutiRequest->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ __('messages.reason') }}</label>
                        <div class="p-3 bg-light rounded">
                            {{ $cutiRequest->reason }}
                        </div>
                    </div>

                    @if ($cutiRequest->bukti)
                        <div class="form-group">
                            <label>{{ __('messages.supporting_document') }}</label>
                            <div class="p-3 bg-light rounded">
                                <a href="{{ asset('storage/' . $cutiRequest->bukti) }}" target="_blank">
                                    <i class="fas fa-file-download"></i> {{ __('messages.view_download_document') }}
                                </a>
                            </div>
                        </div>
                    @endif

                    @if ($cutiRequest->status == 'rejected' && $cutiRequest->rejection_reason)
                        <div class="form-group">
                            <label>{{ __('messages.rejection_reason') }}</label>
                            <div class="p-3 bg-light rounded text-danger">
                                {{ $cutiRequest->rejection_reason }}
                            </div>
                        </div>
                    @endif

                    @if ($cutiRequest->status == 'approved')
                        <div class="form-group">
                            <label>{{ __('messages.approved_by') }}</label>
                            <div class="p-3 bg-light rounded">
                                {{ $cutiRequest->reviewer->name ?? 'HRD' }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{ __('messages.approved_at') }}</label>
                            <div class="p-3 bg-light rounded">
                                {{ $cutiRequest->reviewed_at }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            @if ($cutiRequest->status == 'pending')
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><strong>{{ __('messages.actions') }}</strong></h3>
                            </div>
                            <div class="card-body">
                                <button type="button" class="btn btn-success"
                                    onclick="approveRequest({{ $cutiRequest->id }})">
                                    <i class="fas fa-check"></i> {{ __('messages.approve') }}
                                </button>
                                <button type="button" class="btn btn-danger"
                                    onclick="rejectRequest({{ $cutiRequest->id }})">
                                    <i class="fas fa-times"></i> {{ __('messages.reject') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="rejectModalLabel">{{ __('messages.reject_leave') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('messages.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="rejectForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="rejection_reason">{{ __('messages.rejection_reason') }}</label>
                            <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ __('messages.cancel') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('messages.reject') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function approveRequest(id) {
            if (confirm('{{ __('messages.confirm_approve') }}')) {
                $.post(`/cuti-requests/${id}/approve`, {
                        _token: '{{ csrf_token() }}'
                    })
                    .done(function() {
                        location.reload();
                    })
                    .fail(function() {
                        alert('{{ __('messages.error_approve') }}');
                    });
            }
        }

        function rejectRequest(id) {
            $('#rejectForm').attr('action', `/cuti-requests/${id}/reject`);
            $('#rejectModal').modal('show');
        }
    </script>
@endpush
