@extends('layouts2.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle fa-lg me-3 text-success"></i>
                        <span>{{ session('success') }}</span>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            {{-- Profile Card --}}
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                {{-- Cover Image with Better Positioning --}}
                <div class="profile-cover position-relative" style="height: 180px; background: linear-gradient(135deg, #1e4d2e 0%, #0a3622 100%);">
                    
                    {{-- Profile Image with Enhanced Fallback --}}
                    @php
                        $profileImagePath = 'images/' . $user->profile_image;
                        $defaultImagePath = 'images/unknown.jpg';
                        
                        // Check if user has profile image and file exists
                        if($user->profile_image && file_exists(public_path($profileImagePath))) {
                            $imageSrc = asset($profileImagePath);
                        } elseif(file_exists(public_path($defaultImagePath))) {
                            $imageSrc = asset($defaultImagePath);
                        } else {
                            $imageSrc = null;
                        }
                    @endphp

                    <div class="position-absolute bottom-0 start-50 translate-middle-x" style="margin-bottom: -60px;">
                        @if($imageSrc)
                            <img src="{{ $imageSrc }}"
                                 alt="{{ $user->name }}'s Profile Picture"
                                 class="rounded-circle border border-4 border-white shadow-lg"
                                 width="200" height="200"
                                 style="object-fit: cover; background: white;"
                                 onerror=" this.src='{{ asset('images/unknown.jpg') }}';">
                        @else
                            <div class="rounded-circle border border-4 border-white shadow-lg bg-white d-flex align-items-center justify-content-center"
                                 style="width: 200px; height: 200px;">
                                <i class="fas fa-user-circle fa-4x text-success"></i>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card-body pt-5 mt-5 px-4 px-md-5">
                    {{-- User Name and Role --}}
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-dark mb-2">{{ $user->name }}</h2>
                        <div class="d-inline-block">
                            @if($user->role === 'admin')
                                <span class="badge bg-danger bg-opacity-10 text-white px-3 py-2 rounded-pill">
                                    <i class="fas fa-crown me-1"></i> Admin
                                </span>
                            @elseif($user->role === 'officer')
                                <span class="badge bg-danger bg-opacity-10 text-white px-3 py-2 rounded-pill">
                                    <i class="fas fa-user-shield me-1"></i> Officer
                                </span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-white px-3 py-2 rounded-pill">
                                    <i class="fas fa-user me-1"></i> User
                                </span>
                            @endif
                        </div>
                        <p class="text-muted mt-2 mb-0">
                            <i class="fas fa-calendar-alt me-1 text-success"></i> Member since {{ \Carbon\Carbon::parse($user->created_at)->format('F Y') }}
                        </p>
                    </div>

                    {{-- Profile Information Section --}}
                    <div class="row g-4 mt-3">
                        <div class="col-md-6">
                            <div class="info-card rounded-4 p-4 h-100" style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); border: 1px solid #e9ecef;">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-wrapper rounded-circle p-2 me-3" style="background: rgba(25, 135, 84, 0.1);">
                                        <i class="fas fa-envelope text-success fs-5"></i>
                                    </div>
                                    <h6 class="text-muted mb-0">Email Address</h6>
                                </div>
                                <p class="fs-5 fw-semibold text-dark mb-0 ps-2">{{ $user->email }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-card rounded-4 p-4 h-100" style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); border: 1px solid #e9ecef;">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-wrapper rounded-circle p-2 me-3" style="background: rgba(25, 135, 84, 0.1);">
                                        <i class="fas fa-phone-alt text-success fs-5"></i>
                                    </div>
                                    <h6 class="text-muted mb-0">Phone Number</h6>
                                </div>
                                <p class="fs-5 fw-semibold text-dark mb-0 ps-2">{{ $user->phone ?? 'Not provided' }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-card rounded-4 p-4 h-100" style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); border: 1px solid #e9ecef;">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-wrapper rounded-circle p-2 me-3" style="background: rgba(25, 135, 84, 0.1);">
                                        <i class="fas fa-id-card text-success fs-5"></i>
                                    </div>
                                    <h6 class="text-muted mb-0">NID Number</h6>
                                </div>
                                <p class="fs-5 fw-semibold text-dark mb-0 ps-2">{{ $user->nid ?? 'Not provided' }}</p>
                            </div>
                        </div>

                        @if(auth()->user()->role === 'officer')
                        <div class="col-md-6">
                            <div class="info-card rounded-4 p-4 h-100" style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); border: 1px solid #e9ecef;">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-wrapper rounded-circle p-2 me-3" style="background: rgba(25, 135, 84, 0.1);">
                                        <i class="fas fa-id-card text-success fs-5"></i>
                                    </div>
                                    <h6 class="text-muted mb-0">Status</h6>
                                </div>
                                @if($user->status === 1)
                                    <p class="badge bg-success bg-opacity-10 text-white px-3 py-2 rounded-pill p-2">Approved</p>
                                @else
                                    <p class="badge bg-danger bg-opacity-10 text-white px-3 py-2 rounded-pill p-2">Pendding</p>
                                @endif
                            </div>
                        </div>
                        @endif

                        @if(auth()->user()->role === 'user')
                        <div class="col-md-6">
                            <div class="info-card rounded-4 p-4 h-100" style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); border: 1px solid #e9ecef;">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-wrapper rounded-circle p-2 me-3" style="background: rgba(25, 135, 84, 0.1);">
                                        <i class="fas fa-id-card text-success fs-5"></i>
                                    </div>
                                    <h6 class="text-muted mb-0">Driving License</h6>
                                </div>
                                <p class="fs-5 fw-semibold text-dark mb-0 ps-2">{{ $user->license ?? 'Not provided' }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    

                    {{-- Update Button --}}
                    <div class="text-center mt-5 pt-4 pb-3">
                        <a href="{{ route('profile.edit') }}" class="btn btn-success btn-lg px-5 rounded-pill shadow-sm">
                            <i class="fas fa-pencil-alt me-2"></i> Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Modern Design System */
    :root {
        --success: #198754;
        --success-dark: #0f6b3a;
    }

    /* Profile Cover */
    .profile-cover {
        position: relative;
        overflow: hidden;
    }

    .profile-cover::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path></svg>') no-repeat bottom;
        background-size: cover;
        opacity: 0.5;
    }

    /* Info Cards */
    .info-card {
        transition: all 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        border-color: rgba(25, 135, 84, 0.3) !important;
    }

    .icon-wrapper {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    /* Stat Cards */
    .stat-card {
        transition: all 0.3s ease;
        cursor: default;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(25, 135, 84, 0.3);
    }

    /* Badge Styling */
    .badge {
        font-weight: 500;
        padding: 0.5rem 1.2rem;
        font-size: 0.85rem;
    }

    /* Button Styling */
    .btn-success {
        background: linear-gradient(135deg, var(--success) 0%, var(--success-dark) 100%);
        border: none;
        font-weight: 500;
        transition: all 0.3s ease;
        padding: 0.85rem 2rem;
        font-size: 1rem;
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(25, 135, 84, 0.4);
    }

    .btn-success:active {
        transform: translateY(0);
    }

    /* Alert Styling */
    .alert {
        border-radius: 1rem;
        padding: 1rem 1.5rem;
        border: none;
    }

    /* Animation */
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert {
        animation: slideDown 0.3s ease-out;
    }

    .card {
        animation: fadeInUp 0.5s ease-out;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .profile-cover {
            height: 140px;
        }
        
        .profile-cover img,
        .profile-cover div[class*="rounded-circle"] {
            width: 100px !important;
            height: 100px !important;
        }
        
        .card-body {
            padding: 1.5rem !important;
        }
        
        .info-card {
            margin-bottom: 0;
        }
        
        .stat-card {
            margin-bottom: 1rem;
        }
        
        .btn-success {
            padding: 0.7rem 1.5rem;
            font-size: 0.9rem;
        }
        
        h2 {
            font-size: 1.5rem;
        }
        
        .stat-icon i {
            font-size: 2rem;
        }
        
        .stat-card h3 {
            font-size: 1.5rem;
        }
    }

    /* Tablet Design */
    @media (min-width: 769px) and (max-width: 1024px) {
        .stat-card h3 {
            font-size: 1.8rem;
        }
        
        .stat-icon i {
            font-size: 2.5rem;
        }
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    /* Additional Image Styling */
    .rounded-circle {
        transition: transform 0.3s ease;
    }
    
    .rounded-circle:hover {
        transform: scale(1.05);
    }
</style>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush
@endsection