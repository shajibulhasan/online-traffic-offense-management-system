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
                <div class="card-header bg-success text-white text-center py-2">
                    <h4 class="mb-0"><b>Assign District List</b></h4>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table table-hover text-center align-middle">
                        <thead class="table-success text-white">
                            <tr>
                                <th>Serial</th>
                                <th>Officer Name</th>
                                <th>District Lead</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $id = 1; @endphp
                            @foreach($assign_districts as $assign)
                                @if(Auth::user()->division_lead == 'chattogram' && !in_array($assign->district_lead, ['Bandarban', 'Bramanbaria', 'Chandpur', 'Comilla', 'Chittagong', 'Coxsbazar', 'Feni', 'Khagrachari', 'Lakshmipur', 'Noakhali', 'Rangamati']))
                                    @continue
                                @elseif(Auth::user()->division_lead == 'dhaka' && !in_array($assign->district_lead, ['Dhaka', 'Faridpur', 'Gazipur', 'Gopalganj', 'Kishoreganj', 'Madaripur', 'Manikganj', 'Munshiganj', 'Narayanganj', 'Narsingdi', 'Rajbari', 'Shariatpur', 'Tangail']))
                                    @continue
                                @elseif(Auth::user()->division_lead == 'khulna' && !in_array($assign->district_lead, ['Bagerhat', 'Chuadanga', 'Jashore', 'Jhenaidah', 'Khulna', 'Kushtia', 'Magura', 'Meherpur', 'Narail', 'Satkhira']))
                                    @continue
                                @elseif(Auth::user()->division_lead == 'rajshahi' && !in_array($assign->district_lead, ['Bogura', 'Chapainawabganj', 'Joypurhat', 'Natore', 'Naogaon', 'Pabna', 'Rajshahi', 'Sirajganj']))
                                    @continue
                                @elseif(Auth::user()->division_lead == 'barishal' && !in_array($assign->district_lead, ['Barishal', 'Bhola', 'Jhalokathi', 'Patuakhali', 'Pirojpur']))
                                    @continue
                                @elseif(Auth::user()->division_lead == 'sylhet' && !in_array($assign->district_lead, ['Moulvibazar', 'Sylhet', 'Habiganj', 'Sunamganj']))
                                    @continue                                                               
                                @endif
                            <tr>
                                <td>{{ $id++ }}</td>
                                <td>{{ $assign->name }}</td>
                                <td>{{ $assign->district_lead }}</td>
                                <td>
                                    <a href="{{ route('Admin.updateAssignDistrict', $assign->id) }}" class="btn btn-sm btn-primary">Edit</a>

                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteDistrictModal{{ $assign->id }}">Delete</button>
                                </td>
                            </tr>

                          
                            <div class="modal fade" id="deleteDistrictModal{{ $assign->id }}" tabindex="-1" aria-labelledby="deleteDistrictModalLabel{{ $assign->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <form method="POST" action="{{ route('Admin.assignDistrict.delete', $assign->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-content border-0 rounded-3 shadow">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title" id="deleteDistrictModalLabel{{ $assign->id }}">Confirm Delete</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">Are you sure you want to delete this asssign district lead of <strong>{{$assign->name}}</strong>?</div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
