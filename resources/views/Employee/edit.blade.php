@extends('AdminDashboard.master')

@section('title', 'Edit Employee')

@section('content')

<div class="container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-6">
        <h4>Edit Employee</h4>
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
          <li class="breadcrumb-item active">Edit Employee</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-body">
          <form method="POST" action="{{ route('employees.update', $employee->id) }}">
            @csrf
            @method('PUT')
            <div class="card-header">
              <h4 class="card-title mb-0">Edit Employee</h4>
            </div>

            <div class="card-body">
              <div class="row">

                {{-- Full Name --}}
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Full Name *</label>
                    <input class="form-control" type="text" name="name" value="{{ old('name', $employee->name) }}" required>
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>
                </div>

                {{-- Employee Number --}}
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Employee Number *</label>
                    <input class="form-control" type="text" name="employee_number" value="{{ old('employee_number', $employee->employee_number) }}" required>
                    @error('employee_number') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>
                </div>

                {{-- Role --}}
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Role *</label>
                    <select class="form-control btn-square" name="role_id" required>
                      <option value="">--Select Role--</option>
                      @foreach ($roles as $role)
                      <option value="{{ $role->id }}" {{ old('role_id', $employee->role_id) == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                      </option>
                      @endforeach
                    </select>
                    @error('role_id') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>
                </div>

                {{-- Date of Join --}}
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Date of Join *</label>
                    <input class="form-control" type="date" name="start_date" value="{{ old('start_date', $employee->start_date) }}" required>
                    @error('start_date') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Reporting Manager *</label>
                    <select class="form-control btn-square" name="rm_id" required>
                      <option value="">--Select Employee--</option>
                      @foreach ($rms as $rm)
                      <option value="{{ $rm->id }}" {{ old('rm_id', $employee->rm_id) == $rm->id ? 'selected' : '' }}>{{ $rm->name }} - {{ $rm->role->name }}</option>
                      @endforeach
                    </select>
                    @error('rm_id')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>
                </div>

                {{-- Email --}}
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Email *</label>
                    <input class="form-control" type="email" name="email" value="{{ old('email', $employee->email) }}" required>
                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>
                </div>

                {{-- Mobile Number 1 --}}
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Contact Number 1 *</label>
                    <input class="form-control" type="text" name="mobile_number" value="{{ old('mobile_number', $employee->mobile_number) }}" required>
                    @error('mobile_number') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>
                </div>

                {{-- Mobile Number 2 --}}
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Contact Number 2</label>
                    <input class="form-control" type="text" name="mobile_number_2" value="{{ old('mobile_number_2', $employee->mobile_number_2) }}">
                    @error('mobile_number_2') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>
                </div>

                {{-- NIC --}}
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">NIC *</label>
                    <input class="form-control" type="text" name="nic" value="{{ old('nic', $employee->nic) }}" required>
                    @error('nic') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>
                </div>

                {{-- Date of Birth --}}
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Date of Birth *</label>
                    <input class="form-control" type="date" name="dob" value="{{ old('dob', $employee->dob) }}" required>
                    @error('dob') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>
                </div>

                {{-- Gender --}}
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Gender *</label>
                    <select class="form-control btn-square" name="gender" required>
                      <option value="">--Select Gender--</option>
                      <option value="Male" {{ old('gender', $employee->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                      <option value="Female" {{ old('gender', $employee->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                      <option value="Other" {{ old('gender', $employee->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gender') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>
                </div>

                {{-- Status --}}
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Status *</label>
                    <select class="form-control btn-square" name="status" required>
                      <option value="Available" {{ old('status', $employee->status ? 'Available' : 'Unavailable') == 'Available' ? 'selected' : '' }}>Available</option>
                      <option value="Unavailable" {{ old('status', $employee->status ? 'Available' : 'Unavailable') == 'Unavailable' ? 'selected' : '' }}>Unavailable</option>
                    </select>
                    @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>
                </div>
 
                {{-- New Password --}}
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input class="form-control" type="password" name="password" placeholder="Enter new password">
                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>
                </div>

                {{-- Confirm New Password --}}
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Confirm New Password</label>
                    <input class="form-control" type="password" name="password_confirmation" placeholder="Confirm new password">
                    @error('password_confirmation') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>
                </div>

                

              </div>
            </div>

            <div class="card-footer text-end">
              <button class="btn btn-primary" type="submit">Update Employee</button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
