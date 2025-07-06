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
                        <h4><b>Update Area</b></h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('Admin.updateArea', $area->id) }}" method="POST">
                            @csrf
                            @method('POST') 

                            <div class="mb-4">
                                <label for="thana" class="form-label"><b>Thana Name:</b> <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-house-door"></i></span>
                                    <input type="text" class="form-control shadow-sm" id="thana" name="thana_name" value="{{ old('thana_name', $area->thana_name) }}" disabled>
                                </div>
                                @error('area_name')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="area" class="form-label"><b>Area Name:</b> <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-house-door"></i></span>
                                    <input type="text" class="form-control shadow-sm" id="area" name="area_name" value="{{ old('area_name', $area->area_name) }}">
                                </div>
                                @error('area_name')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="details_area" class="form-label"><b>Details Area:</b> <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-map"></i></span>
                                    <input type="text" class="form-control shadow-sm" id="details_area" name="details_area" value="{{ old('details_area', $area->details_area) }}">
                                </div>
                                @error('details_area')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn  btn-dark d-flex justify-content-center align-items-center">
                                    <i class="bi bi-pencil-square me-2"></i><b>Update Area</b>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection