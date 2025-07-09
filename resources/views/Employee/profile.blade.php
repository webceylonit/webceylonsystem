@extends('AdminDashboard.master')

@section('title', 'Profile')

@section('content')

<style>
    .profile-card {
        border-radius: 20px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    .profile-title h4 {
        font-weight: 600;
    }

    .profile-info p {
        font-weight: 500;
        color: #495057;
        background-color: #f8f9fa;
        padding: 8px 12px;
        border-radius: 8px;
    }

    .form-section {
        border-top: 1px solid #e9ecef;
        padding-top: 25px;
        margin-top: 25px;
    }

    .form-footer button {
        width: 100%;
    }

    .alert {
        border-radius: 10px;
    }

    .form-label {
        font-weight: 600;
        color: #495057;
    }
</style>

<div class="container-fluid">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-6">
                <h4 class="mb-0">Profile Settings</h4>
            </div>
            <div class="col-6 text-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('frontend/assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Profile Container -->
<div class="container-fluid">
    <div class="edit-profile">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-8">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="card profile-card">
                    <div class="card-header text-center">
                        <div class="profile-title">
                            <h4 class="card-title mb-0">My Profile</h4>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Profile Info Display -->
                        <div class="row g-3 profile-info">
                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <p>{{ $employee->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <p>{{ $employee->email }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">NIC</label>
                                <p>{{ $employee->nic }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Gender</label>
                                <p>{{ $employee->gender }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Date of Birth</label>
                                <p>{{ $employee->dob }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Mobile Number 1</label>
                                <p>{{ $employee->mobile_number }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Employee Number</label>
                                <p>{{ $employee->employee_number }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Start Date</label>
                                <p>{{ $employee->start_date }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <p>{{ $employee->status ? 'Available' : 'Unavailable' }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Role</label>
                                <p>{{ $employee->role->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Reporting Manager</label>
                                <p>{{ $employee->rm->name ?? '-' }}</p>
                            </div>
                        </div>

                        <!-- Update Mobile Number -->
                        <div class="form-section">
                            <form method="POST" action="{{ route('profile.updateMb2') }}">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label class="form-label">Mobile Number 2</label>
                                    <input class="form-control" name="mobile_number_2" value="{{ $employee->mobile_number_2 }}" placeholder="Enter Mobile Number 2">
                                </div>
                                <div class="form-footer">
                                    <button class="btn btn-primary">Update Mobile Number</button>
                                </div>
                            </form>
                        </div>

                        <!-- Change Password -->
                        <div class="form-section">
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
                                <div class="form-footer">
                                    <button class="btn btn-primary">Update Password</button>
                                </div>
                            </form>
                        </div>
                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div>
        </div>
    </div>
</div>

@endsection
