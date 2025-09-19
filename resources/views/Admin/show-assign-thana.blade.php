@extends('layouts2.app')

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

<style>
::placeholder {
    color: white !important;
    opacity: 1; /* opacity default 0.5 থাকে, তাই বাড়াতে হবে */
}
</style>
<div class="container py-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-10 col-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header text-white bg-success text-center py-2">
                    <h4 class="mb-0"><b>Assign Thana List</b></h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover text-center align-middle">
                            <thead class="table-success text-white">
                                <tr>
                                    <th>Serial No.</th>
                                    <th>Officer Name</th>
                                    <th>Thana Lead</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $id = 1; @endphp
                                @foreach($assign_thana as $thana)                                    
                                <tr>
                                    <td>{{ $id++ }}</td>
                                    <td>{{ $thana->name }}</td>
                                    <td>{{ $thana->thana_lead }}</td>
                                    <td>
                                        <a href="{{ route('Admin.updateAssignThana', $thana->id) }}" class="btn btn-sm btn-primary">Edit</a>

                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAssignThanaModal{{ $thana->id }}">
                                            Delete
                                        </button>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteAssignThanaModal{{ $thana->id }}" tabindex="-1" aria-labelledby="deleteAssignThanaModalLabel{{ $thana->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 rounded-3 shadow">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title" id="deleteAssignThanaModalLabel{{ $thana->id }}">Confirm Delete</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete assigned thana lead of <strong>{{ $thana->name }}</strong>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('Admin.show-assign-thana.delete', $thana->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Modal -->
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
