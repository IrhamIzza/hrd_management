@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="h2">{{ __('messages.leave_request_detail') }}</h1>
            </div>
            <div class="col-sm-6">
                <div class="float-sm-right">
                    <a href="{{ route('cuti_requests.index') }}" class="btn btn-secondary">
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
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th style="width: 200px">{{ __('messages.start_date') }}</th>
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
                            <th>{{ __('messages.request_date') }}</th>
                            <td>{{ $cutiRequest->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.supporting_document') }}</th>
                            <td>
                                @if ($cutiRequest->bukti)
                                    <a href="{{ asset('storage/' . $cutiRequest->bukti) }}" target="_blank">
                                        <i class="fas fa-file-download"></i> {{ __('messages.view_or_download_document') }}
                                    </a>
                                @else
                                    <span class="text-muted">{{ __('messages.none') }}</span>
                                @endif
                            </td>
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
        </div>
    </div>
@endsection
