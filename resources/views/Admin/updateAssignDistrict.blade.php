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
                    <h4><b>Update Assign District</b></h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('Admin.updateAssignDistrict', $assign_district->id) }}" method="POST">
                        @csrf
                        @method('POST')

                        <!-- Officer Name -->
                        <div class="mb-4">
                            <label for="name" class="form-label"><b>Officer Name:</b> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                <input type="text" class="form-control shadow-sm" id="name" name="name" value="{{ old('name', $assign_district->name) }}" required disabled>
                            </div>
                            @error('name')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- District Selection -->
                        <div class="mb-4">
                            <label for="district_lead" class="form-label"><b>District:</b> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>    
                                    <select id="district" name="district_lead" class="form-select shadow-sm">
                                        <option value="">Select District</option>
                                        @if(Auth::user()->division_lead == 'chattogram')
                                            @foreach(['Bandarban', 'Bramanbaria', 'Chandpur', 'Comilla', 'Chittagong', 'Coxsbazar', 
                                                    'Feni', 'Khagrachari', 'Lakshmipur', 'Noakhali', 'Rangamati'] as $district)
                                                <option value="{{ $district }}" {{ old('district_lead', $assign_district->district_lead) == $district ? 'selected' : '' }}>{{ $district }}</option>
                                            @endforeach
                                        @elseif(Auth::user()->division_lead == 'dhaka')
                                            @foreach(['Dhaka', 'Faridpur', 'Gazipur', 'Gopalganj', 'Kishoreganj', 'Madaripur', 'Manikganj',  
                                                    'Munshiganj', 'Narayanganj', 'Narsingdi', 'Rajbari', 'Shariatpur', 'Tangail'] as $district)
                                                <option value="{{ $district }}" {{ old('district_lead', $assign_district->district_lead) == $district ? 'selected' : '' }}>{{ $district }}</option>
                                            @endforeach
                                        @elseif(Auth::user()->division_lead == 'khulna')
                                            @foreach(['Bagerhat', 'Chuadanga', 'Jashore', 'Jhenaidah', 'Khulna', 
                                                    'Kushtia', 'Magura', 'Meherpur', 'Narail', 'Satkhira'] as $district)
                                                <option value="{{ $district }}" {{ old('district_lead', $assign_district->district_lead) == $district ? 'selected' : '' }}>{{ $district }}</option>
                                            @endforeach
                                        @elseif(Auth::user()->division_lead == 'rajshahi')
                                            @foreach(['Bogura', 'Chapainawabganj', 'Joypurhat', 'Natore', 'Naogaon', 
                                                    'Pabna', 'Rajshahi', 'Sirajganj'] as $district)
                                                <option value="{{ $district }}" {{ old('district_lead', $assign_district->district_lead) == $district ? 'selected' : '' }}>{{ $district }}</option>
                                            @endforeach
                                        @elseif(Auth::user()->division_lead == 'barisal')
                                            @foreach(['Barisal', 'Barguna', 'Bhola', 'Jhalokati', 'Patuakhali', 
                                                    'Pirojpur'] as $district)
                                                <option value="{{ $district }}" {{ old('district_lead', $assign_district->district_lead) == $district ? 'selected' : '' }}>{{ $district }}</option>
                                            @endforeach
                                        @elseif(Auth::user()->division_lead == 'sylhet')
                                            @foreach(['Habiganj', 'Moulvibazar', 'Sunamganj', 'Sylhet'] as $district)
                                                <option value="{{ $district }}" {{ old('district_lead', $assign_district->district_lead) == $district ? 'selected' : '' }}>{{ $district }}</option>
                                            @endforeach
                                        @elseif(Auth::user()->division_lead == 'rangpur')
                                            @foreach(['Dinajpur', 'Gaibandha', 'Kurigram', 'Lalmonirhat', 'Nilphamari', 
                                                    'Panchagarh', 'Rangpur', 'Thakurgaon'] as $district)
                                                <option value="{{ $district }}" {{ old('district_lead', $assign_district->district_lead) == $district ? 'selected' : '' }}>{{ $district }}</option>
                                            @endforeach
                                        @else
                                            <option value="">No districts available</option>
                                        @endif
                                    </select>
                            </div>
                            @error('district_lead')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-dark d-flex justify-content-center align-items-center">
                                <i class="bi bi-pencil-square me-2"></i><b>Update Assign District</b>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
