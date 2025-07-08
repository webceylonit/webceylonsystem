@extends('AdminDashboard.master')

@section('title', 'Sprints')

@section('content')
<div class="container-fluid pt-2">
  <div class="page-title">
    <div class="row">
      <div class="col-6">
        <h4>Sprints</h4>
      </div>
      
      
        <div class="col-6 text-end">
        <a href="{{ route('projects.index') }}" class="btn btn-secondary">← Back to Projects</a>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSprintModal">+ Add Sprint</button>
        
        </div>
      
    </div>
  </div>
</div>

<!-- Status Tabs -->
<div class="card">
  <div class="row">
    <div class="col-md-6 mt-4">
      <ul class="nav nav-tabs border-tab" id="top-tab" role="tablist">
        <li class="nav-item"><a class="nav-link active" id="top-home-tab" data-bs-toggle="tab" href="#top-home" role="tab"><i data-feather="target"></i>All</a></li>
        <li class="nav-item"><a class="nav-link" id="profile-top-tab" data-bs-toggle="tab" href="#top-profile" role="tab"><i data-feather="info"></i>In Progress</a></li>
        <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-bs-toggle="tab" href="#top-contact" role="tab"><i data-feather="check-circle"></i>Completed</a></li>
      </ul>
    </div>
  </div>
</div>

<!-- Sprint List -->
<div class="container-fluid">
  <ul class="list-group">
    @foreach ($sprints as $sprint)
    <li class="list-group-item d-flex justify-content-between align-items-center mb-2 p-3 shadow-sm" 
        style="border-left: {{ ($sprint->end_date < now() && $sprint->status != 'Completed') ? '4px solid red' : '4px solid transparent' }}; border-radius: 5px;">
        <div>
            <h6 class="mb-1">{{ $sprint->name }}</h6>
            <small>Start: {{ $sprint->start_date }} | End: 
                <span style="color: {{ ($sprint->end_date < now() && $sprint->status != 'Completed') ? 'red' : 'inherit' }};">{{ $sprint->end_date }}</span>
            </small>
        </div>
        <span class="badge {{ $sprint->status == 'Completed' ? 'bg-success' : ($sprint->status == 'In Progress' ? 'bg-warning' : 'bg-secondary') }}">
            {{ $sprint->status }}
        </span>
        <div>
            <a href="{{ route('tasks.index', $sprint->id) }}" class="btn btn-info btn-sm">Tasks</a>
            {{-- ✅ Show "Edit" & "Delete" buttons only for Admin & Manager --}}
            
              <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editSprintModal-{{ $sprint->id }}">Edit</button>
              <form action="{{ route('sprints.destroy', $sprint->id) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
              </form>
           
        </div>
    </li>


      <!-- Edit Sprint Modal -->
      
      <div class="modal fade" id="editSprintModal-{{ $sprint->id }}" tabindex="-1" aria-labelledby="editSprintModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editSprintModalLabel">Edit Sprint</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('sprints.update', $sprint->id) }}">
              @csrf
              @method('PUT')
              <input type="hidden" name="project_id" value="{{ $projectId }}">
              <div class="modal-body">
                <div class="mb-3">
                  <label class="form-label">Sprint Name</label>
                  <input type="text" class="form-control" name="name" value="{{ $sprint->name }}" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Start Date</label>
                  <input type="date" class="form-control" name="start_date" value="{{ $sprint->start_date }}" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">End Date</label>
                  <input type="date" class="form-control" name="end_date" value="{{ $sprint->end_date }}" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Status</label>
                  <select class="form-control" name="status">
                    <option value="Not Started" {{ $sprint->status == 'Not Started' ? 'selected' : '' }}>Not Started</option>
                    <option value="In Progress" {{ $sprint->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="Completed" {{ $sprint->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                  </select>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update Sprint</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      
    @endforeach
  </ul>
</div>

<!-- Add Sprint Modal -->

<div class="modal fade" id="addSprintModal" tabindex="-1" aria-labelledby="addSprintModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addSprintModalLabel">Add New Sprint</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="{{ route('sprints.store') }}">
        @csrf
        <input type="hidden" name="project_id" value="{{ $projectId }}">
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Sprint Name</label>
            <input type="text" class="form-control" name="name" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Start Date</label>
            <input type="date" class="form-control" name="start_date" required>
          </div>
          <div class="mb-3">
            <label class="form-label">End Date</label>
            <input type="date" class="form-control" name="end_date" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Status</label>
            <select class="form-control" name="status">
              <option value="Not Started">Not Started</option>
              <option value="In Progress">In Progress</option>
              <option value="Completed">Completed</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save Sprint</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
