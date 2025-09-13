@extends('layouts2.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-success text-white text-center py-4">
                    <img src="{{ $user->profile_image 
                        ? asset('images/' . $user->profile_image) 
                        : asset('images/unknown.jpg') }}" 
                        alt="Profile Picture"
                        class="rounded-circle border border-3 border-light mb-3"
                        width="120" height="120">
                    <h3 class="mb-0">{{ $user->name }}</h3>
                    <p class="text-white mb-0">User Profile</p>
                </div>

                <div class="card-body p-4">
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold">Email</div>
                        <div class="col-sm-8">{{ $user->email }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold">Phone</div>
                        <div class="col-sm-8">{{ $user->phone ?? 'Not provided' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold">NID</div>
                        <div class="col-sm-8">{{ $user->nid ?? 'Not provided' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold">License</div>
                        <div class="col-sm-8">{{ $user->license ?? 'Not provided' }}</div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                            <i class="bi bi-pencil-square"></i> Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
