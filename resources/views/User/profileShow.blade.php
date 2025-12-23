@extends('layouts2.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Profile Card --}}
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-success text-white text-center py-4">
                    {{-- Profile Image --}}
                    @if($user->profile_image && file_exists(public_path('images/' . $user->profile_image)))
                        <img src="{{ asset('images/' . $user->profile_image) }}"
                             alt="Profile Picture"
                             class="rounded-circle border border-3 border-light mb-3 shadow-sm"
                             width="200" height="200">
                    @else
                        <img src="{{ asset('images/unknown.jpg') }}"
                             alt="Profile Picture"
                             class="rounded-circle border border-3 border-light mb-3 shadow-sm"
                             width="200" height="200">
                    @endif

                    <h3 class="mb-1">{{ $user->name }}</h3>
                    <p class="text-white-50 mb-0">User Profile</p>
                </div>

                <div class="card-body p-4">
                    {{-- Email --}}
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold text-muted">Email</div>
                        <div class="col-sm-8">{{ $user->email }}</div>
                    </div>
                    {{-- Phone --}}
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold text-muted">Phone</div>
                        <div class="col-sm-8">{{ $user->phone ?? 'Not provided' }}</div>
                    </div>
                    {{-- NID --}}
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold text-muted">NID</div>
                        <div class="col-sm-8">{{ $user->nid ?? 'Not provided' }}</div>
                    </div>
                    {{-- License --}}
                    @if(auth()->user()->role === 'user')
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold text-muted">License</div>
                        <div class="col-sm-8">{{ $user->license ?? 'Not provided' }}</div>
                    </div>
                    @endif

                    {{-- Update Button --}}
                    <div class="text-center mt-4">
                        <a href="{{ route('profile.edit') }}" class="btn btn-success px-4">
                            <i class="bi bi-pencil-square"></i> Update Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
