@extends('AdminDashboard.master')

@section('title', 'Create Clients')

@section('content')

<div class="container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-6">
        <h4>Create Client</h4>
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
          <li class="breadcrumb-item">Clients</li>
          <li class="breadcrumb-item active">Create</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<!-- Container-fluid starts-->
<div class="container-fluid">
  <form class="card" method="POST" action="{{ route('clients.store') }}">
    @csrf
    <div class="card-header">
      <h4 class="card-title mb-0">Create Client</h4>
    </div>

    <div class="card-body">
      <div class="row">

        <!-- ==== Company Details Section ==== -->
        <div class="col-12">
          <h6 class="mb-3 text-primary">Company Details</h6>
        </div>

        {{-- Company Name --}}
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input class="form-control" type="text" name="company" value="{{ old('company') }}" placeholder="Enter company name">
            @error('company') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
        </div>

        {{-- Company Contact --}}
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">Contact Number</label>
            <input class="form-control" type="text" name="phone" value="{{ old('phone') }}" placeholder="Enter company contact number">
            @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
        </div>

        {{-- Company Email --}}
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input class="form-control" type="email" name="company_email" value="{{ old('company_email') }}" placeholder="Enter company email">
            @error('company_email') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
        </div>

        {{-- Company Address --}}
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea class="form-control" name="address" rows="1" placeholder="Enter company address">{{ old('address') }}</textarea>
            @error('address') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
        </div>

        <!-- ==== Client Details Section ==== -->
        <div class="col-12 mt-4">
          <h6 class="mb-3 text-primary">Client Details</h6>
        </div>

        {{-- Client Name --}}
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">Name *</label>
            <input class="form-control" type="text" name="name" value="{{ old('name') }}" placeholder="Enter client's full name" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
        </div>

        {{-- Designation --}}
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">Designation *</label>
            <input class="form-control" type="text" name="designation" value="{{ old('designation') }}" placeholder="Enter designation" required>
            @error('designation') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
        </div>

        {{-- Email --}}
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">Email *</label>
            <input class="form-control" type="email" name="email" value="{{ old('email') }}" placeholder="Enter email" required>
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
        </div>

        {{-- Client Contact --}}
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">Contact Number *</label>
            <input class="form-control" type="text" name="client_contact" value="{{ old('client_contact') }}" placeholder="Enter contact number" required>
            @error('client_contact') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
        </div>

        <!-- ==== Other Details Section ==== -->
        <div class="col-12 mt-4">
          <h6 class="mb-3 text-primary">Other Details</h6>
        </div>

        {{-- Notes --}}
        <div class="col-md-12">
          <div class="mb-3">
            <label class="form-label">Notes</label>
            <textarea class="form-control" name="notes" rows="2" placeholder="Additional notes (optional)">{{ old('notes') }}</textarea>
            @error('notes') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
        </div>

        {{-- Status --}}
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">Status *</label>
            <select class="form-control" name="status" required>
              <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
              <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
        </div>

      </div>
    </div>

    <div class="card-footer text-end">
      <button class="btn btn-primary" type="submit">Create Client</button>
    </div>
  </form>
</div>

@endsection