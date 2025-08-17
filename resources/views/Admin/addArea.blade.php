@extends("layouts2.app")

@section("content")

<!-- Display Success or Error Messages -->
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
    <div class="row justify-content-center align-items-center" style="min-height: 50vh;">
        <div class="col-md-6 col-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header text-white bg-dark text-center">
                    <h3><b>Add New Area</b></h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('Admin.addArea') }}" method="POST">
                        @csrf
                        <!-- Officer Name -->
                        <div class="mb-4">
                            <label for="officer_name" class="form-label"><b>Thana Name:</b> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-building"></i></span>
                                <input type="text" class="form-control shadow-sm" id="thana_name" name="thana_name" value="{{ Auth::user()->thana_lead }}" required disabled>
                                <input type="text" class="form-control shadow-sm" id="thana_name" name="thana_name" value="{{ Auth::user()->thana_lead }}" required hidden>
                            </div>
                            @error('thana_name')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div> 

                        <!-- Area Name Field -->
                        <div class="mb-4">
                            <label for="area_name" class="form-label"><b>Area Name:</b> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-house-door-fill"></i></span>
                                <input type="text" placeholder="Enter Area Name" class="form-control shadow-sm @error('area_name') is-invalid @enderror" value="{{ old('area_name') }}" id="area_name" name="area_name">
                            </div>
                            @error('area_name')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Detailed Area Field -->
                        <div class="mb-4">
                            <label for="details_area" class="form-label"><b>Detailed Area:</b> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-map"></i></span>
                                <textarea class="form-control shadow-sm @error('details_area') is-invalid @enderror" id="details_area" name="details_area" rows="3" placeholder="Enter Details Area">{{ old('details_area') }}</textarea>
                            </div>
                            @error('details_area')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-custom d-flex justify-content-center align-items-center">
                                <i class="bi bi-plus-circle-fill me-2"></i> <b>Add Area</b>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

