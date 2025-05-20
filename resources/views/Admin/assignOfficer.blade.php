@extends("layouts.app")
@section("content")
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@elseif(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="container-fluid">
    <div class="row justify-content-center align-items-center" style="min-height: 50vh;">
        <div class="col-md-6 col-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header text-white bg-dark text-center">
                    <h3><b>Assign Officer</b></h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('Admin.assignOfficer') }}" method="POST">
                        @csrf
                        @method('post')
                        <div class="mb-4">
                            <label for="officer" class="form-label"><b>Officer Name:</b> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-person-badge-fill"></i></span>
                               <select id="officer" name="officer" class="form-select shadow-sm">
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
                        <label for="area" class="form-label"><b>Area List:</b> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-list-task"></i></span>
                                <select id="area" name="area_name" class="form-select shadow-sm">
                                    <option value="">Select area</option>
                                    @foreach($area_list as $area)
                                        <option value="{{ $area->area_name }}">{{ $area->area_name }}</option>
                                    @endforeach
                                </select>
                        </div>
                         @error('area_name')
                                <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                       
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-custom">
                                <i class="bi bi-plus-circle-fill me-2"></i> <b>Assign Officer</b>
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
</style>
@endpush
