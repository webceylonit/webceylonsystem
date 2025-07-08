@extends('AdminDashboard.master')

@section('title', 'Roles')

@section('content')

<div class="container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-6">
        <h4>Roles List</h4>
      </div>
      <div class="col-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">
              <svg class="stroke-icon">
                <use href="{{ asset('frontend/assets/svg/icon-sprite.svg#stroke-home')}}"></use>
              </svg>
            </a>
          </li>
          <li class="breadcrumb-item active">Roles</li>
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
        <div class="card-header pb-0 card-no-border">
          <a href="{{ route('role.create') }}" class="btn btn-primary">Add Role +</a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="display" id="basic-1">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Role Name</th>
                  <th>Permissions</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($roles as $role)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $role->name }}</td>
                  <td>
                    @if ($role->permissions->isNotEmpty())
                    <ul style="padding-left: 1rem;">
                      @foreach ($role->permissions as $permission)
                      <li>{{ $permission }}</li>
                      @endforeach
                    </ul>
                    @else
                    <span class="text-muted">No Permissions</span>
                    @endif
                  </td>
                  <td>
                    <ul class="action">
                      <li class="edit">
                        <a href="{{ route('role.edit', $role->id) }}">
                          <i class="icon-pencil-alt"></i>
                        </a>
                      </li>
                      <li class="delete">
                        <form id="delete-form-{{ $role->id }}" action="{{ route('role.destroy', $role->id) }}" method="POST" class="delete-form">
                          @csrf
                          @method('DELETE')
                          <button type="button" class="delete-btn" onclick="confirmDelete('delete-form-{{ $role->id }}');" style="border:none; background:none; cursor:pointer; padding:0;">
                            <i class="icon-trash" style="color:red;"></i>
                          </button>
                        </form>
                      </li>
                    </ul>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection