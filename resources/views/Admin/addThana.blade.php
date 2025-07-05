@extends('layouts.app')
@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@elseif(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header text-white bg-dark text-center py-3">
                    <h4><b>Add Thana</b></h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('Admin.addThana') }}" method="post">
                        @csrf
                        <!-- District Dropdown -->
                        <div class="mb-4">
                            <label for="district" class="form-label"><b>District:</b> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-geo-fill"></i></span>
                                    <select id="district" name="district_name" class="form-select shadow-sm">
                                    <option value="{{ Auth::user()->district_lead }}">{{ Auth::user()->district_lead }}</option>
                            </div>
                            @error('district_name')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Thana Name -->
                        <div class="mb-4">
                            <label for="thana" class="form-label"><b>Thana Name:</b> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-buildings"></i></span>
                                <input type="text" class="form-control shadow-sm" id="thana" name="thana_name" placeholder="Enter Thana Name" value="{{ old('thana_name') }}">
                            </div>
                            @error('thana_name')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Contact -->
                        <div class="mb-4">
                            <label for="thana_contact" class="form-label"><b>Contact:</b> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                <input type="text" class="form-control shadow-sm" id="thana_contact" name="contact" placeholder="Enter Thana Contact" value="{{ old('contact') }}">
                            </div>
                            @error('contact')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="mb-4">
                            <label for="thana_address" class="form-label"><b>Detailed Address:</b> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-map"></i></span>
                                <textarea class="form-control shadow-sm" id="thana_address" name="address" rows="3" placeholder="Enter Thana Address">{{ old('address') }}</textarea>
                            </div>
                            @error('address')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-custom d-flex justify-content-center align-items-center">
                                <i class="bi bi-plus-circle-fill me-2"></i><b>Add Thana</b>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
 @endsection

@push('styles')
<style>
  
    .btn-custom {
        background-color: #4CAF50;
        color: white;
        font-size: 16px;
        font-weight: bold;
        padding: 12px 25px;
        border: none;
        border-radius: 5px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 3px 5px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease-in-out;
    }

    .btn-custom:hover {
        background-color: #45a049;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        transform: translateY(-2px);
    }

    .btn-custom:active {
        background-color: #3e8e41;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transform: translateY(2px);
    }

    .btn-custom i {
        margin-right: 8px;
        font-size: 18px;
    }

    .btn-custom b {
        font-size: 16px;
    }

    
    .form-label {
        font-weight: bold;
        color: #555;
    }

    .input-group-text {
        background-color: #f1f1f1;
        border: 1px solid #ccc;
    }

    .text-danger {
        font-size: 0.9rem;
    }

 
    .container {
        background-color: #f8f9fa;
        padding: 50px 15px;
        border-radius: 8px;
    }

    .card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background-color: #007bff;
    }

    .card-body {
        background-color: #ffffff;
        padding: 30px;
    }

    .alert {
        border-radius: 5px;
        padding: 20px;
    }
</style>
@endpush
