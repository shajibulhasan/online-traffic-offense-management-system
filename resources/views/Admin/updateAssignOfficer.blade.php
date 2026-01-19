@extends('layouts2.app')

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@elseif(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
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
                    <h4><b>Update Assign Officer Lead</b></h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('Admin.updateAssignOfficer', $assign_officer->id) }}" method="POST">
                        @csrf
                        @method('POST')

                        <!-- Officer Name -->
                        <div class="mb-4">
                            <label for="name" class="form-label"><b>Officer Name:</b> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                <input type="text" class="form-control shadow-sm bg-success text-white" id="name" name="name" value="{{ $assign_officer->name }}" required disabled>
                            </div>
                        </div>
                        <!-- District Name -->
                        <div class="mb-4">
                            <label for="district" class="form-label"><b>District:</b> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                                <input type="text" class="form-control shadow-sm bg-success text-white" id="district" name="district" value="{{ $assign_officer->district }}" required disabled>
                            </div>
                        </div>
                        <!-- Thana Name -->
                        <div class="mb-4">
                            <label for="thana" class="form-label"><b>Thana:</b> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                                <input type="text" class="form-control shadow-sm bg-success text-white" id="thana" name="thana" value="{{ $assign_officer->thana }}" required disabled>
                            </div>
                        </div>

                        <!-- Area Lead Selection -->
                        <div class="mb-4">
                            <label for="area" class="form-label"><b>Area List:</b> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-list-task"></i></span>
                                <select id="area" name="area_name" class="form-select shadow-sm bg-success text-white" required>
                                    <option value="">Select area</option>
                                    @foreach($area_list as $area)
                                        <option value="{{ $area->area_name }}" 
                                            {{ old('area_name', $assign_officer->area_lead) == $area->area_name ? 'selected' : '' }}>
                                            {{ $area->area_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('area_name')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-success text-white d-flex justify-content-center align-items-center">
                                <i class="bi bi-pencil-square me-2"></i><b>Update Officer Lead</b>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
