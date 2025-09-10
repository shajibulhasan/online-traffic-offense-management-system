@extends('layouts2.app')

@section('content')
<div class="container py-5">
    <div class="card">
        <div class="card-header text-white bg-dark text-center py-2">
            <h4 class="mb-0"><b>{{ Auth::user()->name }} Offense List</b></h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th  class="text-center">Thana</th>
                        <th  class="text-center">Details</th>
                        <th  class="text-center">Fine</th>
                        <th  class="text-center">Point</th>
                        <th class="text-center">Payment Status</th>
                    </tr>
                </thead>
                <tbody>
                 @forelse($offenseList as $offense)
                        <tr>
                            <td class="text-center">{{ $offense->thana }}</td>
                            <td class="text-center">{{ $offense->details }}</td>
                            <td class="text-center">{{ $offense->fine }}</td>
                            <td class="text-center">{{ $offense->point }}</td>  
                             <td class="text-center"><button class="btn btn-primary">Pay Now</button></td>                           
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No offenses found</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
