@extends('layouts2.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-success text-white text-center py-3">
                    <h4>Edit Profile</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 text-center">
                            <img src="{{ $user->profile_image ? asset('images/' . $user->profile_image) : asset('images/unknown.jpg') }}" 
                                 alt="Profile Picture"
                                 class="rounded-circle border mb-3"
                                 width="120" height="120">
                            <input type="file" name="profile_image" class="form-control bg-success text-white">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control bg-success text-white" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control bg-success text-white" value="{{ old('email', $user->email) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control bg-success text-white" value="{{ old('phone', $user->phone) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NID</label>
                            <input type="text" name="nid" class="form-control bg-success text-white" value="{{ old('nid', $user->nid) }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">License</label>
                            @if(is_null($user->license))
                                <input type="text" name="license" placeholder="Not Provided" class="form-control bg-success text-white" value="{{ old('license', $user->license) }}">
                            @else
                                <input type="text" name="license" class="form-control bg-success text-white" value="{{ old('license', $user->license) }}" readonly>
                            @endif
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> Save Changes
                            </button>
                            <a href="{{ route('User.profileShow') }}" class="btn btn-danger">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
