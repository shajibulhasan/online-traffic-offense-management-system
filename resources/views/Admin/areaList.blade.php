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
                                @foreach($areas as  $area)
                                <tr>
                                    <td>{{ $area->id }}</td>
                                    <td>{{ $area->area_name }}</td>
                                    <td>{{ $area->details_area }}</td>
                                    <td><a href="{{ route('Admin.updateArea', $area->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('Admin.area.delete', $area->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
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