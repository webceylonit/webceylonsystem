@extends('AdminDashboard.master')

@section('title', 'Dashboard')

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
                <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
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
        <div class="card-body">
          <div class="list-employee-header">
            <div>
              <div class="light-box">
                <a data-bs-toggle="collapse" href="#collapseEmployee" role="button" aria-expanded="false" aria-controls="collapseEmployee">
                </a>
              </div>
              <a class="btn btn-primary" href="{{ route('employees.create') }}">
                <i class="fa fa-plus"></i> Add Employee
              </a>
            </div>
          </div>

          <div class="list-employee">
            <table class="table" id="employee-list">
              <thead>
                <tr>
                  <th>
                    <div class="form-check">
                      <input class="form-check-input checkbox-primary" type="checkbox">
                    </div>
                  </th>
                  <th><span class="f-light f-w-600">Employee Name</span></th>
                  <th><span class="f-light f-w-600">Email</span></th>
                  <th><span class="f-light f-w-600">Role</span></th>
                  <th><span class="f-light f-w-600">Start Date</span></th>
                  <th><span class="f-light f-w-600">Status</span></th>
                  <th><span class="f-light f-w-600">Actions</span></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($employees as $employee)
                  <tr>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input checkbox-primary" type="checkbox">
                      </div>
                    </td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->role->name }}</td>
                    <td>{{ $employee->start_date }}</td>
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
                      <div class="employee-action">
                        <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning btn-sm">
                          <i class="fa fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('employees.destroys', $employee->id) }}" method="POST" style="display: inline;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this employee?')">
                            <i class="fa fa-trash"></i> Delete
                          </button>
                        </form>
                      </div>
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
