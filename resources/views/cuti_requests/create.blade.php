@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="h2">{{ __('messages.submit_leave') }}</h1>
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

    <hr class="my-3" />

    <div class="card">
        <div class="card-header bg-primary">
            <h3 class="card-title text-white">{{ __('messages.leave_form') }}</h3>
        </div>

        <form action="{{ route('cuti_requests.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="start_date">{{ __('messages.start_date') }}</label>
                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date"
                        name="start_date" value="{{ old('start_date') }}" min="{{ date('Y-m-d') }}">
                    @error('start_date')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="end_date">{{ __('messages.end_date') }}</label>
                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date"
                        name="end_date" value="{{ old('end_date') }}" min="{{ date('Y-m-d') }}">
                    @error('end_date')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="reason">{{ __('messages.reason') }}</label>
                    <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason" rows="4">{{ old('reason') }}</textarea>
                    @error('reason')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="bukti">{{ __('messages.upload_supporting_document') }}</label>
                    <input type="file" class="form-control @error('bukti') is-invalid @enderror" name="bukti"
                        id="bukti">
                    @error('bukti')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">{{ __('messages.submit') }}</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            // Set minimum end date based on start date
            $('#start_date').change(function() {
                $('#end_date').attr('min', $(this).val());
            });
        });
    </script>
@endpush
