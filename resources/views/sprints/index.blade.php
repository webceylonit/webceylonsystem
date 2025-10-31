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
        @permission('Project Grid View')
        <a href="{{ route('projects.index') }}" class="btn btn-secondary">← Back to Projects</a>
        @endpermission
        @permission('Create Sprints')
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSprintModal">+ Add Sprint</button>
        @endpermission
      </div>
    </div>
  </div>
</div>

<div class="container-fluid">
  <ul class="list-group">
    @forelse ($sprints as $sprint)
      @php
        $isOverdue = \Carbon\Carbon::parse($sprint->end_date)->isPast() && $sprint->status !== 'Completed';
        $startForInput = \Carbon\Carbon::parse($sprint->start_date)->format('Y-m-d');
        $endForInput   = \Carbon\Carbon::parse($sprint->end_date)->format('Y-m-d');
      @endphp

      <li class="list-group-item d-flex justify-content-between align-items-center mb-2 p-3 shadow-sm"
          style="border-left: {{ $isOverdue ? '4px solid red' : '4px solid transparent' }}; border-radius: 5px;">
        <div>
          <h6 class="mb-1">{{ $sprint->name }}</h6>
          <small>
            Start: {{ \Carbon\Carbon::parse($sprint->start_date)->format('d-m-Y') }} |
            End:
            <span style="color: {{ $isOverdue ? 'red' : 'inherit' }};">
              {{ \Carbon\Carbon::parse($sprint->end_date)->format('d-m-Y') }}
            </span>
          </small>

          {{-- Task counts --}}
          <div class="mt-2">
            <span class="badge bg-dark">
              Total: {{ $sprint->tasks_count ?? 0 }}
            </span>
            <span class="badge bg-success">
              ✅ Completed: {{ $sprint->completed_tasks_count ?? 0 }}
            </span>
            <span class="badge bg-warning text-dark">
              ⌛ Pending: {{ $sprint->pending_tasks_count ?? 0 }}
            </span>
          </div>
        </div>

        <span class="badge {{ $sprint->status == 'Completed' ? 'bg-success' : ($sprint->status == 'In Progress' ? 'bg-warning text-dark' : 'bg-secondary') }}">
          {{ $sprint->status }}
        </span>

        <div class="ms-2">
          @permission('View Tasks')
          <a href="{{ route('tasks.index', $sprint->id) }}" class="btn btn-info btn-sm">
            Tasks ({{ $sprint->tasks_count ?? 0 }})
          </a>
          @endpermission

          @permission('Edit Tasks')
          <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editSprintModal-{{ $sprint->id }}">Edit</button>
          @endpermission

          @permission('Delete Tasks')
          <form action="{{ route('sprints.destroy', $sprint->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
          </form>
          @endpermission
        </div>
      </li>

      <!-- Edit Sprint Modal -->
      <div class="modal fade" id="editSprintModal-{{ $sprint->id }}" tabindex="-1" aria-labelledby="editSprintModalLabel-{{ $sprint->id }}" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editSprintModalLabel-{{ $sprint->id }}">Edit Sprint</h5>
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
                  <input type="date" class="form-control" name="start_date" value="{{ $startForInput }}" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">End Date</label>
                  <input type="date" class="form-control" name="end_date" value="{{ $endForInput }}" required>
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
    @empty
      <li class="list-group-item">No sprints found.</li>
    @endforelse
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
