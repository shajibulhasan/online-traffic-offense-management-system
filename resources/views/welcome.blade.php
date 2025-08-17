@extends('layouts2.app')
@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    
    @guest
        <h1>Welcome to the Online Traffic Offense Management System</h1>
        <p>Please log in or register to continue.</p>
    @else
        <h1>Welcome, {{ Auth::user()->name }}</h1>
        <p>You are logged in as {{ Auth::user()->role }}.</p>
    @endguest
    <!-- @include('auth.login'); -->
    
</div>
@endsection
