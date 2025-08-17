@extends('layouts2.app')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-4 mx-4" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@elseif(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mt-4 mx-4" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="container py-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-lg-10 col-md-11">
            <div class="card border-0 shadow rounded-4">
                <div class="card-header bg-dark text-white text-center rounded-top-4">
                    <h4 class="fw-bold mb-0">Assign Officer List</h4>
                </div>
                <div class="card-body px-4 py-4">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered text-center align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Serial</th>
                                    <th>Officer Name</th>
                                    <th>Thana Name</th>
                                    <th>Area Lead</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $id = 1; @endphp
                                @forelse($assign_areaOfficer as $assign)
                                <tr>
                                    <td>{{ $id++ }}</td>
                                    <td>{{ $assign->name }}</td>
                                    <td>{{ Auth::user()->thana_lead }}</td>
                                    <td>{{ $assign->area_lead }}</td>
                                    <td>
                                        <a href="{{ route('Admin.updateAssignOfficer', $assign->id) }}" class="btn btn-sm btn-primary me-1">Edit</a>
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $assign->id }}">
                                            Delete
                                        </button>

                                       
                                        <div class="modal fade" id="deleteModal{{ $assign->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $assign->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content rounded-3">
                                                    <div class="modal-header bg-danger text-white rounded-top-3">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $assign->id }}">Confirm Unassign</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        Are you sure you want to unassign <br><strong>{{ $assign->name }}</strong> from the area lead?
                                                    </div>
                                                    <div class="modal-footer justify-content-center">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('Admin.assignOfficer.delete', $assign->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Yes, Unassign</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                       
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-muted">No officers assigned yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div> 
                </div> 
            </div>
        </div> 
    </div> 
</div> 
@endsection
