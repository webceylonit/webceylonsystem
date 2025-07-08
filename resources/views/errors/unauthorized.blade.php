@extends('AdminDashboard.master')

@section('title', 'Unauothorized')

@section('content')



<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
        <div class="text-center mt-5">
            <h2 class="text-danger">403 - Unauthorized</h2>
            <p>You do not have permission to access this page.</p>
            <a href="{{ route('dashboard') }}" class="btn btn-primary">Go Back to Dashboard</a>
        </div>
    </div>
</div>

@endsection