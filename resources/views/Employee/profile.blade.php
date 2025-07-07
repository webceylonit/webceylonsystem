@extends('AdminDashboard.master')

@section('title', 'Profile')

@section('content')

<style>

</style>

<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h4>Profile Settings </h4>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('frontend/assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                            </svg></a></li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="edit-profile">
        <div class="row justify-content-center">
            <div class="col-xl-4">
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="card">
                    <div class="card-header text-center">
                        <h4 class="card-title mb-0">My Profile</h4>
                        <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.updateName') }}">
                            @csrf
                            @method('PUT')
                            <div class="row mb-2">
                                <div class="profile-title text-center">
                                    <div class="d-flex flex-column align-items-center">

                                        <h5 class="mb-1">{{ $employee->name }}</h5>
                                        <p class="mb-0">{{ $employee->role->name }}</p>
                                    </div>
                                </div>

                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email-Address</label>
                                <input class="form-control" value="{{$employee->email}}" placeholder="email address" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input class="form-control" name="name" value="{{ $employee->name }}" placeholder="name" required>

                            </div>
                            <div class="form-footer text-center">
                                <button class="btn btn-primary btn-block mb-4">Update Name</button>
                            </div>
                        </form>
                        <form method="POST" action="{{ route('profile.updatePassword') }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Current Password</label>
                                <input class="form-control" type="password" name="current_password" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input class="form-control" type="password" name="new_password" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirm New Password</label>
                                <input class="form-control" type="password" name="new_password_confirmation" required>
                            </div>
                            <div class="form-footer text-center">
                                <button class="btn btn-primary btn-block">Update Password</button>
                            </div>


                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
<!-- Container-fluid Ends-->


@endsection