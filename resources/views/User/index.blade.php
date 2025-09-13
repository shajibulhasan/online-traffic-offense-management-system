@extends('layouts2.app')

@section('content')
<div class="container py-5">
    <div class="card">
        <div class="alert alert-danger" role="alert">
           @php
                $unpaid_point = 0;
                $point = 0;
                foreach ($offenseList as $offense) {
                    $createdAt = \Carbon\Carbon::parse($offense->created_at);
                    if($createdAt->gte(now()->subDays(30))) {
                        $point += $offense->point;
                        if($offense->status === 'unpaid') {
                            $unpaid_point += $offense->point;
                        }
                    }
                }
            @endphp

            @if($unpaid_point >= 15)
                <h4 class="alert-heading text-center">You have 15 or more points in the last 30 days. Your license has been suspended until all payments are made.</h4>
            @elseif($point >= 15)
                <h4 class="alert-heading text-center">You have 15 or more points in the last 30 days. Your license has been revoked for the next week.</h4>
            @else
                <h4 class="alert-heading text-center">You have {{ $point ?? 0 }} points in the last 30 days. Drive Safely!</h4>
            @endif
        </div>
        <div class="card-header text-white bg-success text-center py-2">
            <h4 class="mb-0"><b>My Offense List</b></h4>
        </div>
        <div class="card-body">
            <table class="table table-responsive table">
                <thead class="table bg-success">
                    <tr class="text-white">
                        <th  class="text-center text-white">Thana</th>
                        <th  class="text-center text-white">Details</th>
                        <th  class="text-center text-white">Fine</th>
                        <th  class="text-center text-white">Point</th>
                        <th class="text-center text-white">Payment Status</th>
                        <th class="text-center text-white">Action</th>
                    </tr>
                </thead>
                <tbody>
                 @forelse($offenseList as $offense)
                        <tr>
                            <td class="text-center">{{ $offense->thana }}</td>
                            <td class="text-center">{{ $offense->details }}</td>
                            <td class="text-center">{{ $offense->fine }}</td>
                            <td class="text-center">{{ $offense->point }}</td>   
                            <td class="text-center">
                                @if($offense->status === 'paid')
                                    <span class="badge bg-success">Paid</span>
                                @else
                                    <span class="badge bg-danger">Unpaid</span>
                                @endif
                            </td>
                            <td class="text-center action">
                                @if($offense->status === 'paid')
                                    <span>
                                        Transaction ID: <span class="badge bg-success">{{ $offense-> transaction_id }}</span>                                     
                                    </span>
                                    
                                @else
                                <form action="{{ route('bkash-create-payment', [$offense->fine, $offense->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Pay Now</button>
                                </form>                                
                                @endif
                            </td>
                                    
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">NO Offense</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

