@guest
    @include('auth.login')
@else
    @extends('layouts2.app')

    @section('content')
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            @if (session('role')=='user')
                            <h3>Total My Offenses</h3>
                            @else
                            <h3>Total Offenses Recorded</h3>
                            @endif
                        </div>
                        <div class="card-body text-black text-center">
                            <h1 class="text-center">
                                @if (session('role')=='user')
                                    {{ $userOffenseCount }}
                                @else
                                    {{ $totalOffenseCount }}
                                @endif
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
@endguest
