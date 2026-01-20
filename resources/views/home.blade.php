@guest
 @include('auth.login');
@else
 @include('layouts2.app')
 @section('content')
    <div class="container">
        <h1>Welcome to the Online Traffic Offense Management System</h1>
        <p>This is a simple application to manage traffic offenses.</p>
    </div>
 @endsection
@endguest