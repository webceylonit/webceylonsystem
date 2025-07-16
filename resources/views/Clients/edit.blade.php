@extends('AdminDashboard.master')

@section('title', 'Edit Clients')

@section('content')

<div class="container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-6">
        <h4>Edit Client</h4>
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
          <li class="breadcrumb-item active">Edit</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<!-- Container-fluid starts-->
<div class="container-fluid">
  <form class="card" method="POST" action="{{ route('clients.update', $client->id) }}">
    @csrf
    @method('PUT')
    <div class="card-header">
      <h4 class="card-title mb-0">Edit Client</h4>
    </div>

    <div class="card-body">
      <div class="row">

        <!-- ==== Company Details ==== -->
        <div class="col-12">
          <h6 class=" text-primary">Company Details</h6>
        </div>

        <div class="col-md-6 mt-3">
          <label class="form-label">Name</label>
          <input type="text" name="company" value="{{ old('company', $client->company) }}" class="form-control" placeholder="Enter company name">
          @error('company') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="col-md-6 mt-3">
          <label class="form-label">Contact Number</label>
          <input type="text" name="phone" value="{{ old('phone', $client->phone) }}" class="form-control" placeholder="Enter contact number">
          @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="col-md-6 mt-3">
          <label class="form-label">Email</label>
          <input type="email" name="company_email" value="{{ old('company_email', $client->company_email) }}" class="form-control" placeholder="Enter company email">
          @error('company_email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="col-md-6 mt-3">
          <label class="form-label">Address</label>
          <textarea name="address" rows="1" class="form-control" placeholder="Enter company address">{{ old('address', $client->address) }}</textarea>
          @error('address') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- ==== Client Details ==== -->
        <div class="col-12 mt-4">
          <h6 class="text-primary">Client Details</h6>
        </div>

        <div class="col-md-6 mt-3">
          <label class="form-label">Name *</label>
          <input type="text" name="name" value="{{ old('name', $client->name) }}" class="form-control" required>
          @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="col-md-6 mt-3">
          <label class="form-label">Designation *</label>
          <input type="text" name="designation" value="{{ old('designation', $client->designation) }}" class="form-control" required>
          @error('designation') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="col-md-6 mt-3">
          <label class="form-label">Email *</label>
          <input type="email" name="email" value="{{ old('email', $client->email) }}" class="form-control" required>
          @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="col-md-6 mt-3">
          <label class="form-label">Contact Number *</label>
          <input type="text" name="client_contact" value="{{ old('client_contact', $client->client_contact) }}" class="form-control" required>
          @error('client_contact') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- ==== Other Details ==== -->
        <div class="col-12 mt-4">
          <h6 class=" text-primary">Other Details</h6>
        </div>

        <div class="col-md-12 mt-3">
          <label class="form-label">Notes</label>
          <textarea name="notes" rows="2" class="form-control">{{ old('notes', $client->notes) }}</textarea>
          @error('notes') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="col-md-6 mt-3">
          <label class="form-label">Status *</label>
          <select class="form-control" name="status" required>
            <option value="Active" {{ old('status', $client->status) == 'Active' ? 'selected' : '' }}>Active</option>
            <option value="Inactive" {{ old('status', $client->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
          </select>
          @error('status') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

      </div>
    </div>

    <div class="card-footer text-end">
      <button class="btn btn-primary" type="submit">Update Client</button>
    </div>
  </form>
</div>


@endsection