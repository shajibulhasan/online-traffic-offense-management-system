@extends('layouts.app')

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@elseif(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header text-white bg-dark text-center py-3">
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
                                <input type="text" class="form-control shadow-sm" id="name" name="name" value="{{ $assign_officer->name }}" required disabled>
                            </div>
                        </div>

                        <!-- Area Lead Selection -->
                        <div class="mb-4">
                            <label for="area" class="form-label"><b>Area List:</b> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-list-task"></i></span>
                                <select id="area" name="area_name" class="form-select shadow-sm" required>
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
                            <button type="submit" class="btn btn-dark d-flex justify-content-center align-items-center">
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
