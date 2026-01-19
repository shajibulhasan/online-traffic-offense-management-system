@extends("layouts2.app")
@section("content")
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
    <div class="row justify-content-center align-items-center" style="min-height: 50vh;">
        <div class="col-md-6 col-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header text-white bg-success text-center">
                    <h3><b>Assign Officer</b></h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('Admin.assignOfficer') }}" method="POST">
                        @csrf
                        @method('post')
                        <!-- Officer Name -->
                        <div class="mb-4">
                            <label for="officer" class="form-label"><b>Officer Name:</b> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-badge-fill"></i></span>
                                <select id="officer" name="officer_name" class="form-select shadow-sm bg-success text-white">
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
                                <select id="thana" name="thana" class="form-select bg-success text-white" required>
                                    <option value="">Select Thana</option>
                                </select>
                            </div>
                        </div>

                        <!-- Area List -->
                        <div class="mb-4">
                        <label for="area" class="form-label"><b>Area List:</b> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text "><i class="bi bi-list-task"></i></span>
                                <select id="area" name="area_name" class="form-select shadow-sm bg-success text-white">
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
                            <button type="submit" class="btn btn-success d-flex justify-content-center align-items-center">
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
