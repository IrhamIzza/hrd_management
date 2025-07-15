@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit Profile</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group text-center">
                            <img src="{{ auth()->user()->profile_photo_url ?? asset('default-avatar.png') }}" class="rounded-circle mb-2" width="100" height="100" style="object-fit:cover;">
                            <div>
                                <input type="file" name="avatar" class="form-control-file mt-2">
                                <small class="text-muted">Format: jpg, png, max 2MB</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="{{ old('username', auth()->user()->username) }}" required>
                        </div>
                        <div class="form-group">
                            <label>Telepon</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', auth()->user()->phone) }}">
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="address" class="form-control">{{ old('address', auth()->user()->address) }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection