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
<div class="container py-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-10 col-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header text-white bg-dark text-center py-2">
                    <h4 class="mb-0"><b>Officer List</b></h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered text-center align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Serial No.</th>
                                    <th>Officer Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php 
                                    $id = 1;
                                @endphp
                                @foreach($officers as  $officer)
                                <tr>
                                    <td>{{  $id++ }}</td>
                                    <td>{{  $officer->name }}</td>
                                    <td>{{  $officer->phone }}</td>
                                    <td>{{  $officer->email }}</td>
                                   
                                    <td>
                                        <form action="{{ route('officers.approve', $officer->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary">Approve</button>
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
