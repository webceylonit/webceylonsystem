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
                    <div class="col-md-12 mb-1">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input class="form-control" type="text" name="name" placeholder="First Name" value="{{ old('first_name') }}">
                        @error('first_name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input class="form-control" type="email" name="email" placeholder="Email" value="{{ old('email') }}">
                        @error('email')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Start Date</label>
                        <input class="form-control" type="date" name="start_date" value="{{ old('start_date') }}">
                        @error('start_date')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input class="form-control" type="password" name="password" placeholder="Password">
                        @error('password')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Re-enter Password</label>
                        <input class="form-control" type="password" name="password_confirmation" placeholder="Re-enter Password">
                        @error('password_confirmation')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    </div>
                    
                    <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select class="form-control btn-square" name="role_id">
                        <option value="">--Select Role--</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                            {{ $role->name }}
                            </option>
                        @endforeach
                        </select>
                        @error('role_id')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-control btn-square" name="status">
                        <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    </div>
                    <div class="col-md-12">
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