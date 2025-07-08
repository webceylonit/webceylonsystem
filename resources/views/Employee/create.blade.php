@extends('AdminDashboard.master')

@section('title', 'Dashboard')

@section('content')

<div class="container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-6">
        <h4>Employee Create</h4>
      </div>
      <div class="col-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">
              <svg class="stroke-icon">
                <use href="{{ asset('frontend/assets/svg/icon-sprite.svg#stroke-home') }}"></use>
              </svg>
            </a>
          </li>
          <li class="breadcrumb-item">HR</li>
          <li class="breadcrumb-item active">Employee Create</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<!-- Container-fluid starts-->
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-body">
          <form class="card" method="POST" action="{{ route('employees.store') }}">
            @csrf
            <div class="card-header">
              <h4 class="card-title mb-0">Create Employee</h4>
              <!-- <div class="card-options">
                    <a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                    <a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a>
                </div> -->
            </div>
            <div class="card-body">
              <div class="row">

                {{-- Full Name --}}
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input class="form-control" type="text" name="name" placeholder="Full Name" value="{{ old('name') }}">
                    @error('name')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>
                </div>

                {{-- NIC --}}
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">NIC</label>
                    <input class="form-control" type="text" name="nic" placeholder="National Identity Card Number" value="{{ old('nic') }}">
                    @error('nic')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>
                </div>

                {{-- Gender --}}
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Gender</label>
                    <select class="form-control btn-square" name="gender">
                      <option value="">--Select Gender--</option>
                      <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                      <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                      <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gender')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>
                </div>

                {{-- Date of Birth --}}
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Date of Birth</label>
                    <input class="form-control" type="date" name="dob" value="{{ old('dob') }}">
                    @error('dob')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>
                </div>

                {{-- Mobile Number --}}
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Mobile Number</label>
                    <input class="form-control" type="text" name="mobile_number" placeholder="Mobile Number" value="{{ old('mobile_number') }}">
                    @error('mobile_number')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>
                </div>

                {{-- Email --}}
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input class="form-control" type="email" name="email" placeholder="Email" value="{{ old('email') }}">
                    @error('email')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>
                </div>

                {{-- Employee Number --}}
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Employee Number</label>
                    <input class="form-control" type="text" name="employee_number" placeholder="Employee Number" value="{{ old('employee_number') }}">
                    @error('employee_number')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>
                </div>

                {{-- Role --}}
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select class="form-control btn-square" name="role_id">
                      <option value="">--Select Role--</option>
                      @foreach ($roles as $role)
                      <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                      @endforeach
                    </select>
                    @error('role_id')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>
                </div>

                {{-- Start Date --}}
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Start Date</label>
                    <input class="form-control" type="date" name="start_date" value="{{ old('start_date') }}">
                    @error('start_date')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>
                </div>

                {{-- Status --}}
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select class="form-control btn-square" name="status">
                      <option value="Available" {{ old('status') == 'Available' ? 'selected' : '' }}>Available</option>
                      <option value="Unavailable" {{ old('status') == 'Unavailable' ? 'selected' : '' }}>Unavailable</option>
                    </select>
                    @error('status')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>
                </div>

                {{-- Password --}}
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input class="form-control" type="password" name="password" placeholder="Password">
                    @error('password')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>
                </div>

                {{-- Confirm Password --}}
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Re-enter Password</label>
                    <input class="form-control" type="password" name="password_confirmation" placeholder="Re-enter Password">
                    @error('password_confirmation')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>
                </div>

              </div>
            </div>

            <div class="card-footer text-end">
              <button class="btn btn-primary" type="submit">Create Employee</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>

@endsection