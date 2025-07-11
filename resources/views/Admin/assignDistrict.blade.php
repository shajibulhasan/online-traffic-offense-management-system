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
                    <h3><b>Assign District Lead</b></h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('Admin.assignDistrict') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="officer" class="form-label"><b>Officer Name:</b> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-person-badge"></i></span>
                                <select id="officer" name="officer_name" class="form-select shadow-sm">
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
                            <label for="district" class="form-label"><b>District:</b> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-geo-fill"></i></span>
                                <select id="district" name="district" class="form-select shadow-sm">
                                    <option value="">Select District</option>
                                    @if(Auth::user()->division_lead == 'chattogram'){
                                        @foreach(['Bandarban', 'Bramanbaria', 'Chandpur', 'Comilla', 'Chittagong', 'Coxsbazar', 
                                                  'Feni', 'Khagrachari', 'Lakshmipur', 'Noakhali', 'Rangamati'] as $district)
                                            <option value="{{ $district }}">{{ $district }}</option>
                                        @endforeach
                                    }
                                    @elseif(Auth::user()->division_lead == 'dhaka'){
                                        @foreach(['Dhaka', 'Faridpur', 'Gazipur', 'Gopalganj', 'Kishoreganj', 'Madaripur', 'Manikganj',  
                                                'Munshiganj', 'Narayanganj', 'Narsingdi', 'Rajbari', 'Shariatpur', 'Tangail'] as $district)
                                            <option value="{{ $district }}">{{ $district }}</option>
                                        @endforeach
                                    }
                                    @elseif(Auth::user()->division_lead == 'khulna'){
                                        @foreach(['Bagerhat', 'Chuadanga', 'Jashore', 'Jhenaidah', 'Khulna', 
                                                  'Kushtia', 'Magura', 'Meherpur', 'Narail', 'Satkhira'] as $district)
                                            <option value="{{ $district }}">{{ $district }}</option>
                                        @endforeach
                                    }
                                    @elseif(Auth::user()->division_lead == 'rajshahi'){
                                        @foreach(['Bogura', 'Chapainawabganj', 'Joypurhat', 'Natore', 'Naogaon', 
                                                  'Pabna', 'Rajshahi', 'Sirajganj'] as $district)
                                            <option value="{{ $district }}">{{ $district }}</option>
                                        @endforeach
                                    }
                                    @elseif(Auth::user()->division_lead == 'barisal'){
                                        @foreach(['Barisal', 'Barguna', 'Bhola', 'Jhalokati', 'Patuakhali', 
                                                  'Pirojpur'] as $district)
                                            <option value="{{ $district }}">{{ $district }}</option>
                                        @endforeach
                                    }
                                    @elseif(Auth::user()->division_lead == 'sylhet'){
                                        @foreach(['Habiganj', 'Moulvibazar', 'Sunamganj', 'Sylhet'] as $district)
                                            <option value="{{ $district }}">{{ $district }}</option>
                                        @endforeach
                                    }
                                    @elseif(Auth::user()->division_lead == 'rangpur'){
                                        @foreach(['Dinajpur', 'Gaibandha', 'Kurigram', 'Lalmonirhat', 'Nilphamari', 
                                                  'Panchagarh', 'Rangpur', 'Thakurgaon'] as $district)
                                            <option value="{{ $district }}">{{ $district }}</option>
                                        @endforeach
                                    }
                                    @else
                                        <option value="">No districts available</option>
                                    @endif
                                </select>
                            </div>
                            @error('district')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-custom">
                                <i class="bi bi-plus-circle-fill me-2"></i> <b>Assign District</b>
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
