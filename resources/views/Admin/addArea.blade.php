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
    <style>
    ::placeholder {
        color: white !important;
        opacity: 1; 
    }
    </style>

<div class="container py-5">
    <div class="row justify-content-center align-items-center" style="min-height: 50vh;">
        <div class="col-md-6 col-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header text-white bg-success text-center">
                    <h3><b>Add New Area</b></h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('Admin.addArea') }}" method="POST">
                        @csrf
                        <!-- District Name Field -->
                        <div class="mb-4">
                            <label class="form-label"><b>District:</b> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-geo-fill"></i></span>
                                <select id="district" name="district" class="form-select bg-success text-white">
                                    <option value="">Select District</option>
                                    @foreach([
                                        'Bagerhat','Bandarban','Barguna','Barisal','Bhola','Bogura',
                                        'Brahmanbaria','Chandpur','Chapai Nawabganj','Chittagong',
                                        'Chuadanga','Comilla','Coxsbazar','Dhaka','Dinajpur','Faridpur',
                                        'Feni','Gaibandha','Gazipur','Gopalganj','Habiganj','Jamalpur',
                                        'Jessore','Jhalokathi','Jhenaidah','Joypurhat','Khagrachari',
                                        'Khulna','Kishoreganj','Kurigram','Kushtia','Lakshmipur',
                                        'Lalmonirhat','Madaripur','Magura','Manikganj','Meherpur',
                                        'Moulvibazar','Munshiganj','Mymensingh','Naogaon','Narail',
                                        'Narayanganj','Narsingdi','Natore','Netrokona','Nilphamari',
                                        'Noakhali','Pabna','Panchagarh','Patuakhali','Pirojpur',
                                        'Rajbari','Rajshahi','Rangamati','Rangpur','Satkhira',
                                        'Shariatpur','Sherpur','Sirajganj','Sunamganj','Sylhet',
                                        'Tangail','Thakurgaon'
                                    ] as $district)
                                        <option value="{{ $district }}">{{ $district }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Thana Name Field -->
                        <div class="mb-4">
                            <label class="form-label"><b>Thana:</b> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-building"></i></span>
                                <select id="thana" name="thana_name" class="form-select bg-success text-white" required>
                                    <option value="">Select Thana</option>
                                </select>
                            </div>
                        </div>


                        <!-- Area Name Field -->
                        <div class="mb-4">
                            <label for="area_name" class="form-label"><b>Area Name:</b> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-house-door-fill"></i></span>
                                <input type="text" placeholder="Enter Area Name" class="form-control shadow-sm @error('area_name') is-invalid @enderror bg-success text-white" value="{{ old('area_name') }}" id="area_name" name="area_name">
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
                                <textarea class="form-control shadow-sm @error('details_area') is-invalid @enderror bg-success text-white" id="details_area" name="details_area" rows="3" placeholder="Enter Details Area">{{ old('details_area') }}</textarea>
                            </div>
                            @error('details_area')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-success d-flex justify-content-center align-items-center">
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


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const districtSelect = document.getElementById('district');
    const thanaSelect = document.getElementById('thana');

    districtSelect.addEventListener('change', function () {
        const district = this.value;
        thanaSelect.innerHTML = '<option value="">Loading...</option>';

        if (!district) {
            thanaSelect.innerHTML = '<option value="">Select Thana</option>';
            return;
        }

        fetch(`/get-thanas-by-district/${encodeURIComponent(district)}`)
            .then(res => res.json())
            .then(data => {
                thanaSelect.innerHTML = '<option value="">Select Thana</option>';
                data.forEach(thana => {
                    let opt = document.createElement('option');
                    opt.value = thana.thana_name;
                    opt.textContent = thana.thana_name;
                    thanaSelect.appendChild(opt);
                });
            });
    });

});
</script>
@endpush

