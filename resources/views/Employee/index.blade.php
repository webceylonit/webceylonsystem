@extends('AdminDashboard.master')

@section('title', 'Employees')

@section('content')

<div class="container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-6">
        <h4>Employee List</h4>
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
          <li class="breadcrumb-item">HR</li>
          <li class="breadcrumb-item active">Employee List</li>
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
          <a href="{{ route('employees.create') }}" class="btn btn-primary">Add Employee +</a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="display" id="basic-1">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Employee Number</th>
                  <th>Name</th>
                  <th>Role</th>
                  <th>Date of Join</th>
                  <th>Email</th>
                  <th>Contact 1</th>
                  <th>Contact 2</th>
                  <th>Reporting Manager</th>
                  <th>NIC</th>
                  <th>DOB</th>
                  <th>Gender</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($employees as $employee)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $employee->employee_number }}</td>
                  <td>{{ $employee->name }}</td>
                  <td>{{ $employee->role->name }}</td>
                  <td>{{ $employee->start_date }}</td>
                  <td>{{ $employee->email }}</td>
                  <td>{{ $employee->mobile_number }}</td>
                  <td>{{ $employee->mobile_number_2 ?? '-' }}</td>
                  <td>{{ $employee->rm->name ?? '-' }}</td>
                  <td>{{ $employee->nic }}</td>
                  <td>{{ $employee->dob }}</td>
                  <td>{{ $employee->gender }}</td>
                  <td>
                    @if ($employee->status === 'Available')
                    <span class="badge badge-light-primary">Available</span>
                    @elseif ($employee->status === 'UnAvailable')
                    <span class="badge badge-light-secondary">UnAvailable</span>
                    @else
                    <span class="badge badge-light-warning">Unknown</span>
                    @endif
                  </td>
                  <td>
                    <ul class="action">
                      <li class="edit">
                        <a href="{{ route('employees.edit', $employee->id) }}">
                          <i class="icon-pencil-alt"></i>
                        </a>
                      </li>
                      <li class="delete">
                        <form id="delete-form-{{ $employee->id }}" action="{{ route('employees.destroys', $employee->id) }}" method="POST" class="delete-form">
                          @csrf
                          @method('DELETE')
                          <button type="button" class="delete-btn" onclick="confirmDelete('delete-form-{{ $employee->id }}');" style="border:none; background:none; cursor:pointer; padding:0;">
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