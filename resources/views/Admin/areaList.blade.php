@extends('layouts.app')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@elseif(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header text-white bg-dark text-center py-2">
                    <h4 class="mb-0"><b>Area List</b></h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered text-center align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Serial No.</th>
                                    <th>Area Name</th>
                                    <th>Details Area</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $id = 1; @endphp
                                @foreach($areas as $area)
                                <tr>
                                    <td>{{ $id++ }}</td>
                                    <td>{{ $area->area_name }}</td>
                                    <td>{{ $area->details_area }}</td>
                                    <td>
                                        <a href="{{ route('Admin.updateArea', $area->id) }}" class="btn btn-sm btn-primary">Edit</a>

                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $area->id }}">
                                            Delete
                                        </button>

                                        <div class="modal fade" id="deleteModal{{ $area->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $area->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 rounded-3 shadow">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $area->id }}">Confirm Delete</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete area <strong>{{ $area->area_name }}</strong>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('Admin.area.delete', $area->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                       
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
