@extends('layouts2.app')
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
    <style>
    ::placeholder {
        color: white !important;
        opacity: 1; 
    }
    </style>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-success text-white text-center">
                    <h4 class="mb-0">Update Offense</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('Officer.updateOffense', $offense->id) }}" method="POST">
                        @csrf
                        @method('POST') 

                        <div class="mb-3">
                            <label for="driver_name" class="form-label">Driver Name</label>
                            <input type="text" class="form-control bg-success text-white" id="driver_name" name="driver_name"
                                value="{{ $offense->driver_name }}" required readonly>
                            <input type="hidden" name="driver_id" value="{{ $offense->driver_id  }}">                        
                        </div>

                        <div class="mb-3">
                            <label for="thana_name" class="form-label">Thana Name</label>
                            <input type="text" class="form-control bg-success text-white" id="thana_name" name="thana_name"
                                value="{{ $offense->thana_name }}" required readonly>
                        </div>

                        <div class="mb-3">
                            <label for="details_offense" class="form-label">Details Offense</label>
                            <textarea class="form-control bg-success text-white" id="details_offense" name="details_offense"
                                    rows="3" required>{{ $offense->details_offense }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="fine" class="form-label">Fine</label>
                            <input type="number" class="form-control bg-success text-white" id="fine" name="fine"
                                value="{{ $offense->fine }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="point" class="form-label">Point</label>
                            <input type="number" class="form-control bg-success text-white" id="point" name="point"
                                value="{{ $offense->point }}" required>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-success">Update Offense</button>
                            <a href="{{ route('Officer.offenseList') }}" class="btn btn-danger ms-2">Back to List</a>
                        </div>
                    </form>

                </div>
            </div>
         </div>
    </div>
@endsection