@extends("layouts.app")
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

<div class="container-fluid">
    <div class="row justify-content-center align-items-center" style="min-height: 50vh;">
        <div class="col-md-6 col-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header text-white bg-dark text-center">
                    <h3><b>Assign District Lead</b></h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('Admin.add-area') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="officer" class="form-label"><b>Officer Name:</b> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-house-door-fill"></i></span>
                                <select id="officer" name="officer" class="form-select shadow-sm">
                                <option value="">Select Officer</option>
                                </select>
                            </div>
                            @error('officer')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="district" class="form-label"><b>District:</b> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-geo-fill"></i></span>
                                <select id="district" name="districtName" class="form-select shadow-sm">
                                    <option value="">Select District</option>
                                    <option value="Dhaka">Dhaka</option>
                                    <option value="Gazipur">Gazipur</option>
                                    <option value="Munshiganj">Munshiganj</option>
                                    <option value="Kishoreganj">Kishoreganj </option>
                                    <option value="Shariatpur">Shariatpur </option>
                                    <option value="Gopalganj">Gopalganj</option>
                                    <option value="Narayanganj">Narayanganj </option>
                                    <option value="Manikganj">Manikganj </option>
                                    <option value="Faridpur">Faridpur</option>
                                    <option value="Norsigdi">Norsigdi</option>
                                    <option value="Rajbari">Rajbari </option>
                                    <option value="Tangail">Tangail</option>
                                    <option value="Madaripur">Madaripur</option>
                                    <option value="Mymensingh">Mymensingh</option>
                                    <option value="Sherpur">Sherpur</option>
                                    <option value="Jamalpur">Jamalpur</option>
                                    <option value="Netrokona">Netrokona</option>
                                    <option value="Chittagong">Chittagong</option>
                                    <option value="Coxsbazar">Coxsbazar</option>
                                    <option value="">Bandarban</option>
                                    <option value="Bandarban">Comilla</option>
                                    <option value="Bramanbaria">Bramanbaria</option>
                                    <option value="Chandpur">Chandpur</option>
                                    <option value="Feni">Feni</option>
                                    <option value="lakhimpur">lakhimpur</option>
                                    <option value="Noakahli">Noakahli</option>
                                    <option value="Rangamati">Rangamati</option>
                                    <option value="khagrachari">khagrachari </option>
                                    <option value="Khulna">Khulna</option>
                                    <option value="Jessor">Jessor</option>
                                    <option value="Satkhira">Satkhira</option>
                                    <option value="Kushtia">Kushtia</option>
                                    <option value="Chuadanga">Chuadanga </option>
                                    <option value="Bagerhat">Bagerhat </option>
                                    <option value="Jhenaidah">Jhenaidah </option>
                                    <option value="Magura">Magura</option>
                                    <option value="Meherpur">Meherpur</option>
                                    <option value="Norail">Norail</option>
                                    <option value="Rajshahi">Rajshahi</option>
                                    <option value="Nouga">Nouga</option>
                                    <option value="Shirajganj">Shirajganj</option>
                                    <option value="Joypurhat">Joypurhat </option>
                                    <option value="Bogura">Bogura</option>
                                    <option value="Chapainawabganj">Chapainawabganj</option>
                                    <option value="Natore">Natore</option>
                                    <option value="Pabna">Pabna</option>
                                    <option value="Nilphamari">Nilphamari</option>
                                    <option value="Dinajpur">Dinajpur</option>
                                    <option value="Panchagar">Panchagar</option>
                                    <option value="Gaibandha">Gaibandha</option>
                                    <option value="Kurigram">Kurigram </option>
                                    <option value="Lalmonirhat">Lalmonirhat</option>
                                    <option value="Rangpur">Rangpur </option>
                                    <option value="Thakurgaon">Thakurgaon</option>
                                    <option value="Bhola">Bhola</option>
                                    <option value="Barisal">Barisal</option>
                                    <option value="Pirojpur">Pirojpur</option>
                                    <option value="Borguna">Borguna</option>
                                    <option value="Jhalokath">Jhalokath</option>
                                    <option value="Patuakhali">Patuakhali</option>
                                    <option value="Moulvibazar">Moulvibazar</option>
                                    <option value="Sylhet">Sylhet</option>
                                    <option value="Habiganj">Habiganj </option>
                                    <option value="Sunamganj">Sunamganj </option>
                                </select>
                            </div>
                            @error('districtName')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-custom d-flex justify-content-center align-items-center">
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

    .btn-custom i {
        margin-right: 8px; 
        font-size: 18px; 
    }

    .btn-custom b {
        font-size: 16px; 
    }
</style>
@endpush
