@extends('layouts2.app')

@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@elseif(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<style>
    #offenseFormFields {
        display: none;
    }
    #driverNameContainer {
        display: none;
    }
::placeholder {
    color: white !important;
    opacity: 1; /* opacity default 0.5 থাকে, তাই বাড়াতে হবে */
}
</style>

<div class="container-fluid">
    <div class="row justify-content-center align-items-center" style="min-height: 50vh;">
        <div class="col-md-6 col-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-success text-white text-center">
                    <h1>Add Offense</h1>
                </div>

                <div class="card-body">
                    <form action="{{ route('Officer.addOffense') }}" method="POST" onsubmit="return validateDriverId();">
                        @csrf

                        {{-- Officer Name --}}
                        <div class="mb-4">
                            <label for="officer"><b>Officer Name:</b></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-badge-fill"></i></span>
                                <input type="text" class="form-control bg-success text-white" value="{{ Auth::user()->name }}" id="officer" readonly>
                            </div>
                        </div>

                        {{-- Search Driver --}}
                        <div class="mb-4">
                            <label class="form-label"><b>Search Driver:</b><span class="text-danger">*</span></label>
                            <div class="input-group mb-2">
                                <select id="searchType" class="form-select bg-success text-white" onchange="updatePlaceholder()">
                                    <option value="" selected>Select Driver</option>
                                    <option value="phone">Phone</option>
                                    <option value="email">Email</option>
                                    <option value="license">Driver License</option>
                                    <option value="nid">NID</option>
                                </select>
                                <input type="text" id="searchValue" class="form-control text-white bg-success" placeholder="Select search type first" disabled> 
                                <button type="button" onclick="searchDriver()" class="btn btn-outline-primary" disabled id="searchBtn">Search</button>
                            </div>
                            <div id="driverResult" class="fw-bold mb-2 text-success"></div>
                            <input type="hidden" id="driver_id" name="driver_id" value="{{ old('driver_id') }}" required>
                            @error('driver_id')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Driver Name (shown after successful search) --}}
                        <div class="mb-4" id="driverNameContainer">
                            <label for="driverName"><b>Driver Name:</b></label>
                            <input type="text" id="driverName" class="form-control driver_name bg-success text-white" readonly>
                        </div>

                        {{-- Remaining Fields --}}
                        <div id="offenseFormFields">

                            {{-- Thana --}}
                            <div class="mb-4">
                                <label for="thana"><b>Area Lead:</b><span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-house-add-fill"></i></span> 
                                    @foreach($thana_list as $thana)                                   
                                        <input type="text" class="form-control mb-2 bg-success text-white" value="{{ $thana->thana_name ?? $thana->area_name }}" id="thana" name="thana_name" readonly>
                                    @endforeach
                                </div>
                                @error('thana_name')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Offense Details --}}
                            <div class="mb-4">
                                <label for="offense"><b>Detailed Offense:</b><span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-map"></i></span>
                                    <textarea class="form-control @error('details_offense') is-invalid @enderror bg-success text-white" name="details_offense" id="offense" rows="3" placeholder="Enter Details Offense">{{ old('details_offense') }}</textarea>
                                </div>
                                @error('details_offense')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Fine --}}
                            <div class="mb-4">
                                <label for="fine"><b>Fine:</b><span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-cash-coin"></i></span>
                                    <input type="text" class="form-control @error('fine') is-invalid @enderror bg-success text-white" name="fine" id="fine" placeholder="Enter fine amount" value="{{ old('fine') }}">
                                </div>
                                @error('fine')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Point --}}
                            <div class="mb-4">
                                <label for="point"><b>Point:</b><span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-marker-tip"></i></span>
                                    <input type="text" class="form-control @error('point') is-invalid @enderror bg-success text-white" name="point" id="point" placeholder="Enter points" value="{{ old('point') }}">
                                </div>
                                @error('point')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Submit --}}
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-success d-flex justify-content-center align-items-center">
                                    <i class="bi bi-plus-circle-fill me-2"></i><b>Add Offense</b>
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript --}}
<script>
    function updatePlaceholder() {
        const searchType = document.getElementById('searchType').value;
        const searchInput = document.getElementById('searchValue');
        const searchBtn = document.getElementById('searchBtn');

        if (!searchType) {
            searchInput.placeholder = "Select search type first";
            searchInput.disabled = true;
            searchBtn.disabled = true;
            searchInput.value = "";
            return;
        }

        searchInput.disabled = false;
        searchBtn.disabled = false;

        const placeholders = {
            phone: "Enter phone number...",
            email: "Enter email address...",
            license: "Enter driver license number...",
            nid: "Enter NID number..."
        };

        searchInput.placeholder = placeholders[searchType] || "Enter value...";
    }

    function searchDriver() {
        const type = document.getElementById('searchType').value;
        const value = document.getElementById('searchValue').value.trim();
        const resultDiv = document.getElementById('driverResult');

        if (!type || !value) {
            alert("Please select a search type and provide a value.");
            return;
        }

        fetch(`/officer/search-driver?type=${type}&value=${encodeURIComponent(value)}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('driver_id').value = data.driver.id;
                    document.getElementById('driverName').value = data.driver.name;

                    document.getElementById('driverNameContainer').style.display = 'block';
                    document.getElementById('offenseFormFields').style.display = 'block';
                    

                     resultDiv.innerHTML = "";
                } else {
                    resultDiv.innerHTML = `<span class="text-danger">${data.message}</span>`;
                    document.getElementById('driver_id').value = '';
                    document.getElementById('driverNameContainer').style.display = 'none';
                    document.getElementById('offenseFormFields').style.display = 'none';
                }
            })
            .catch((e) => {
                resultDiv.innerHTML = `<span class="text-danger">Error: ${e}</span>`;
            });
    }

    document.addEventListener('DOMContentLoaded', updatePlaceholder);

    function validateDriverId() {
        const driverId = document.getElementById('driver_id').value;
        if (!driverId) {
            alert('Please search and select a valid driver before submitting.');
            return false;
        }
        return true;
    }
</script>
@endsection
