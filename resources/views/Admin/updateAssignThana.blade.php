@extends('layouts2.app')

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@elseif(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="container py-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-8 col-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header text-white bg-dark text-center py-3">
                    <h4><b>Update Thana</b></h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('Admin.updateAssignThana', $thana->id) }}" method="POST">
                        @csrf
                        @method('POST')

                        <!-- Officer Name -->
                        <div class="mb-4">
                            <label for="officer_name" class="form-label"><b>Officer Name:</b> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                <input type="text" class="form-control shadow-sm" id="officer_name" name="officer_name" value="{{ old('officer_name', $thana->name) }}" required disabled>
                            </div>
                            @error('officer_name')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Thana List -->
                        <div class="mb-4">
                            <label for="thana_name" class="form-label"><b>Thana List:</b> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-list-task"></i></span>
                                <select name="thana_name" id="thana_name" class="form-select shadow-sm" required>
                                    <option value="">Select Thana</option>
                                    @foreach($thana_list as $item)
                                        <option value="{{ $item->thana_name }}" {{ $item->thana_name == $thana->thana_lead ? 'selected' : '' }}>
                                            {{ $item->thana_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('thana_name')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-dark d-flex justify-content-center align-items-center">
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
