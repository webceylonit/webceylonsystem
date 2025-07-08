@extends('AdminDashboard.master')

@section('title', 'Edit Role')

@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h4>Edit Role</h4>
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
                    <li class="breadcrumb-item">Roles</li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">

                <form method="POST" action="{{ route('role.update', $role->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="card-header">
                        <h4 class="card-title mb-0">Edit Role</h4>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            {{-- Name --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Role Name *</label>
                                    <input class="form-control" type="text" name="name" value="{{ old('name', $role->name) }}">
                                    @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- Permissions --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="permissions">Edit Permissions *</label>
                                    <select class="form-control select2" name="permissions[]" id="permissions" multiple required>
                                        @foreach($permissions as $permission)
                                            <option value="{{ $permission->id }}"
                                                {{ in_array($permission->id, $rolePermissions) ? 'selected' : '' }}>
                                                {{ $permission->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('permissions')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12 text-end">
                                <button class="btn btn-primary" type="submit">Update Role</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script>
    $(document).ready(function() {
        $('#permissions').select2({
            placeholder: "Select permissions...",
            allowClear: true,
            width: '100%',
            closeOnSelect: false
        });
    });
</script>
@endsection
