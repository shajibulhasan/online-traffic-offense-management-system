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
                        <h4><b>Update Assign District</b></h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('Admin.updateAssignDistrict',$assign_district->id) }}" method="POST">
                            @csrf
                            @method('POST') 

                            <div class="mb-4">
                                <label for="officer" class="form-label"><b>officer Name:</b> <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-house-door"></i></span>
                                    <input type="text" class="form-control shadow-sm" id="officer" name="officer_name" value="{{ old('officer_name', $assign_district->officer_name) }}">
                                </div>
                                @error('officer_name')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

     
                            <div class="mb-4">
                            <label for="district" class="form-label"><b>District:</b> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-geo-fill"></i></span>
                                <select id="district" name="district" class="form-select shadow-sm">
                                    <option value="">Select District</option>
                                    @foreach(['Dhaka', 'Gazipur', 'Munshiganj', 'Kishoreganj', 'Shariatpur', 'Gopalganj', 'Narayanganj', 'Manikganj', 'Faridpur', 'Norsingdi', 'Rajbari', 'Tangail', 'Madaripur', 'Mymensingh', 'Sherpur', 'Jamalpur', 'Netrokona', 'Chittagong', 'Cox\'s Bazar', 'Bandarban', 'Comilla', 'Brahmanbaria', 'Chandpur', 'Feni', 'Lakshmipur', 'Noakhali', 'Rangamati', 'Khagrachari', 'Khulna', 'Jessore', 'Satkhira', 'Kushtia', 'Chuadanga', 'Bagerhat', 'Jhenaidah', 'Magura', 'Meherpur', 'Narail', 'Rajshahi', 'Naogaon', 'Sirajganj', 'Joypurhat', 'Bogura', 'Chapainawabganj', 'Natore', 'Pabna', 'Nilphamari', 'Dinajpur', 'Panchagarh', 'Gaibandha', 'Kurigram', 'Lalmonirhat', 'Rangpur', 'Thakurgaon', 'Bhola', 'Barisal', 'Pirojpur', 'Barguna', 'Jhalokathi', 'Patuakhali', 'Moulvibazar', 'Sylhet', 'Habiganj', 'Sunamganj'] as $district)
                                        <option value="{{ $district }}" {{$assign_district->district == $district ? 'selected' : '' }}>{{ $district }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('district')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-warning d-flex justify-content-center align-items-center">
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