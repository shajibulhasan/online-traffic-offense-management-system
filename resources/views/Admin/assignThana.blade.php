@extends("layouts.app")
@section("content")
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@elseif(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
<div class="container-fluid">
    <div class="row justify-content-center allign-iteams-center" style="main-height: 50vh">
        <div class="col-md-6 col-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header text-white bg-dark text-center">
                <h3><b>Assign Thana</b></h3>
                </div>
                <div class="card-body">
                    <form action="{{Route('Admin.assignThana')}}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for=""><b>Officer Name:</b><span class="text-danger">*</span></label>
                            <div class="input-group">
                             <span class="input-group-text bg-light"><i class="bi bi-person-badge"></i></span>
                             <select name="officer_name" id="officer" class="form-select shadow-sm">
                                <option value="">Select Officer</option>
                                @foreach($officers as $officer)
                                <option value="{{ $officer->id }}">{{ $officer->name }}</option>
                                @endforeach
                             </select>
                             </div>
                             @error('officer_name')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="thana-list"><b>Thana List:</b><span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-house-door"></i>
                                </span>
                                <select name="thana_name" id="thana" class="form-select shadow-sm">
                                    <option value="">Selcet Thana List</option>
                                    @foreach($thana_list as $thana)
                                    <option value="{{ $thana->thana_name }}">{{ $thana->thana_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('thana')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-custom d-flex justify-content-center align-items-center">
                                <i class="bi bi-plus-circle-fill me-2"><b>Assign Thana</b></i>
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