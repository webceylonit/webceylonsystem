@extends('AdminDashboard.master')

@section('title', 'Project Details')

@section('content')

<div class="container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-6">
        <h4>Project Details</h4>
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
          <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Projects</a></li>
          <li class="breadcrumb-item active">Details</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid">
  <div class="card">
    <div class="card-header">
      <!-- First Row: Project Code -->
      <div class="row">
        <div class="col-12">
          <h5 class="mb-0">Project Code: {{ $project->project_code }}</h5>
        </div>
      </div>

      <!-- Second Row: Buttons aligned to the right -->
      <div class="row mt-2">
        <div class="col-12 text-end">
          <div class="d-inline-flex flex-wrap gap-1">
            @permission('Kanbans')
            <a href="{{ route('kanban.board', ['project_id' => $project->id]) }}" class="btn btn-info btn-sm">Kanban</a>
            @endpermission

            @permission('View Sprints')
            <a href="{{ route('sprints.index', ['project_id' => $project->id]) }}" class="btn btn-secondary btn-sm">Sprints</a>
            @endpermission

            @permission('Create Documents')
            <a href="{{ route('projectDocs.create', ['project_id' => $project->id]) }}" class="btn btn-primary btn-sm">Create Document</a>
            @endpermission

            @permission('Create Invoices')
            <a href="{{ route('invoices.create', ['project_id' => $project->id]) }}" class="btn btn-sm text-white" style="background-color: gray;">Create Invoice</a>
            @endpermission

            @permission('Edit Projects')
            <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-warning btn-sm">Edit</a>
            @endpermission

            @permission('Delete Projects')
            <form action="{{ route('projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this project?');" style="display:inline;">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
            @endpermission

            <a href="{{ route('projects.tableView') }}" class="btn btn-dark btn-sm">Back to List</a>
          </div>
        </div>
      </div>
    </div>





    <div class="card-body table-responsive">
      <table class="table table-bordered">
        <!-- Project Details -->
        <thead class="table-primary">
          <tr>
            <th colspan="2">Project Details</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th>Name</th>
            <td>{{ $project->name }}</td>
          </tr>
          <tr>
            <th>Category</th>
            <td>{{ $project->category->name ?? '-' }}</td>
          </tr>
          <tr>
            <th>Status</th>
            <td>
              @if ($project->status === 'Completed')
              <span class="badge badge-light-success">{{ $project->status }}</span>
              @elseif ($project->status === 'In Progress')
              <span class="badge badge-light-warning">{{ $project->status }}</span>
              @elseif ($project->status === 'On Hold')
              <span class="badge badge-light-secondary">{{ $project->status }}</span>
              @elseif ($project->status === 'Cancelled')
              <span class="badge badge-light-danger">{{ $project->status }}</span>
              @else
              <span class="badge badge-light-primary">{{ $project->status }}</span>
              @endif
            </td>
          </tr>

          <tr>
            <th>Priority</th>
            <td>{{ $project->priority }}</td>
          </tr>
          <tr>
            <th>Estimated Budget</th>
            <td>
              {{ $project->estimate_budget !== null ? 'LKR ' . number_format($project->estimate_budget, 2) : '-' }}
            </td>

          </tr>
          <tr>
            <th>Start Date</th>
            <td>{{ $project->start_date->format('d-m-Y') }}</td>
          </tr>
          <tr>
            <th>Deadline</th>
            <td>{{ $project->deadline->format('d-m-Y') }}</td>
          </tr>
          <tr>
            <th>Description</th>
            <td>{{ $project->description }}</td>
          </tr>
          @if ($project->attachment)
          <tr>
            <th>Attachment</th>
            <td><a href="{{ asset('storage/' . $project->attachment) }}" target="_blank" class="btn btn-sm btn-info">View / Download</a></td>
          </tr>
          @endif
          <tr>
            <th>Additional Note</th>
            <td>{{ $project->additional_note ?? '-' }}</td>
          </tr>
        </tbody>

        <!-- Client Details -->
        <thead class="table-success">
          <tr>
            <th colspan="2">Client Details</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th>Company Name</th>
            <td>{{ $project->client->company ?? '-' }}</td>
          </tr>
          <tr>
            <th>Client Name</th>
            <td>{{ $project->client->name ?? '-' }}</td>
          </tr>
          <tr>
            <th>Designation</th>
            <td>{{ $project->client->designation ?? '-' }}</td>
          </tr>
          <tr>
            <th>Contact Number</th>
            <td>{{ $project->client->client_contact ?? '-' }}</td>
          </tr>
          <tr>
            <th>Email</th>
            <td>{{ $project->client->email ?? '-' }}</td>
          </tr>
          <tr>
            <th>Company Email</th>
            <td>{{ $project->client->company_email ?? '-' }}</td>
          </tr>
          <tr>
            <th>Phone</th>
            <td>{{ $project->client->phone ?? '-' }}</td>
          </tr>
          <tr>
            <th>Address</th>
            <td>{{ $project->client->address ?? '-' }}</td>
          </tr>
          <tr>
            <th>Notes</th>
            <td>{{ $project->client->notes ?? '-' }}</td>
          </tr>
        </tbody>

        <!-- Authorized Persons -->
        @if($project->authorizedPersons->count())
        <thead class="table-warning">
          <tr>
            <th colspan="2">Authorized Persons</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($project->authorizedPersons as $person)
          <tr>
            <th>{{ $person->name }}</th>
            <td>
              <strong>Designation:</strong> {{ $person->designation }}<br>
              <strong>Contact:</strong> {{ $person->contact }}<br>
              <strong>Email:</strong> {{ $person->email }}
            </td>
          </tr>
          @endforeach
        </tbody>
        @endif

        <!-- Assigned Employees -->
        @if($project->employees->count())
        <thead class="table-info">
          <tr>
            <th colspan="2">Assigned Employees</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($project->employees as $employee)
          <tr>
            <th>{{ $employee->name }}</th>
            <td>{{ $employee->mobile_number }}</td>
          </tr>
          @endforeach
        </tbody>
        @endif

      </table>
    </div>

    <div class="card-footer text-end">

    </div>
  </div>
</div>

@endsection