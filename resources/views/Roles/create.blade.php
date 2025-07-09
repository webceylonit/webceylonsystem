@extends('AdminDashboard.master')

@section('title', 'Create Roles')

@section('content')

<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h4>Role Create</h4>
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
                    <li class="breadcrumb-item active">Create</li>
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

                <form method="POST" action="{{ route('role.store') }}">
                    @csrf
                    <div class="card-header">
                        <h4 class="card-title mb-0">Create Role</h4>

                    </div>
                    <div class="card-body">
                        <div class="row">

                            {{-- Name --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Role Name *</label>
                                    <input class="form-control" type="text" name="name" placeholder="Name" value="{{ old('name') }}">
                                    @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="permissions">Add Permissions *</label>
                                    <div class="row">
                                        @foreach($permissions as $permission)
                                        <div class="col-md-3"> {{-- 12 / 4 = 3 (4 columns per row) --}}
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    name="permissions[]"
                                                    id="permission_{{ $permission->id }}"
                                                    value="{{ $permission->id }}"
                                                    {{ (is_array(old('permissions')) && in_array($permission->id, old('permissions'))) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @error('permissions')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>



                        </div>
                        <div class="row">
                            <div class="col-md-12 text-end">
                                <div class="mb-3">
                                    <button class="btn btn-primary" type="submit">Create Role</button>
                                </div>
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
<!-- jQuery and Select2 -->

<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

<script>
    $(document).ready(function() {
        $('#permissions').select2({
            placeholder: "Select permissions...",
            allowClear: true,
            width: '100%', // Ensures it fits the form
            closeOnSelect: false // Allows multiple selections with one click
        });

    });
</script>
@endsection