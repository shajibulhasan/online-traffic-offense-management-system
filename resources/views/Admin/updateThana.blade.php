@extends('layouts2.app')

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
    <style>
    ::placeholder {
        color: white !important;
        opacity: 1; 
    }
    </style>

<div class="container py-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-8 col-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header text-white bg-success text-center py-3">
                    <h4><b>Update Thana</b></h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('Admin.updateThana', $thana->id) }}" method="POST">
                        @csrf  <!-- CSRF token for security -->

                        <div class="mb-4">
                            <label for="thana" class="form-label"><b>Thana Name:</b> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-buildings"></i></span>
                                <input type="text" class="form-control shadow-sm bg-success text-white" id="thana" name="thana_name" value="{{ $thana->thana_name }}">
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
                                <input type="text" class="form-control shadow-sm bg-success text-white" id="thana_contact" name="contact" placeholder="Enter Thana Contact" value="{{ $thana->contact }}">
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
                                <textarea class="form-control shadow-sm bg-success text-white" id="thana_address" name="address" rows="3" placeholder="Enter Thana Address">{{ $thana->address }}</textarea>
                            </div>
                            @error('address')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn  btn-success text-white d-flex justify-content-center align-items-center">
                                <i class="bi bi-pencil-square me-2"></i><b>Update Thana</b>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
