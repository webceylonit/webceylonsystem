@extends('AdminDashboard.master')

@section('title', 'Tasks for Sprint: ' . $sprint->name)

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container-fluid pt-2">
  <div class="page-title">
    <div class="row">
      <div class="col-6">
        <h4>Tasks for {{ $sprint->name }}</h4>
      </div>
      <div class="col-6 text-end">
        @permission('View Sprints')
          <a href="{{ route('sprints.index', ['project_id' => $sprint->project_id]) }}" class="btn btn-secondary">← Back to Sprint</a>
        @endpermission
        @permission('Create Tasks')
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTaskModal">+ Add Task</button>
        @endpermission
      </div>
    </div>
  </div>
</div>

<!-- Task List -->
<div class="container-fluid">
  <ul id="taskList" class="list-group">
    @foreach ($tasks as $task)
      <li class="list-group-item d-flex justify-content-between align-items-center mb-1"
          data-id="{{ $task->id }}"
          style="border: {{ ($task->due_date < now() && $task->status != 'Done') ? '2px solid red' : 'none' }};">
        <div class="d-flex align-items-start gap-2">
          <span class="drag-handle text-muted" title="Drag to reorder" style="cursor: grab; user-select: none;">☰</span>
          <div>
            <h6 class="mb-1">{{ $task->name }}</h6>
            <small>Assigned to: {{ $task->assignedTo->name }}</small><br>
            <small>Status:
              <span class="badge {{ $task->status == 'Done' ? 'bg-success' : ($task->status == 'In Progress' ? 'bg-warning' : 'bg-secondary') }}">
                {{ $task->status }}
              </span>
            </small>
          </div>
        </div>

        <div class="d-flex gap-1">
          <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#updateTaskModal-{{ $task->id }}">Requirements</button>
          @permission('Edit Tasks')
            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editTaskModal-{{ $task->id }}">Edit</button>
          @endpermission
          @permission('Delete Tasks')
            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
          @endpermission
        </div>
      </li>

      {{-- Edit Task Modal --}}
      <div class="modal fade" id="editTaskModal-{{ $task->id }}" tabindex="-1" aria-labelledby="editTaskModalLabel-{{ $task->id }}" aria-hidden="true">
        <div class="modal-dialog"><div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editTaskModalLabel-{{ $task->id }}">Edit Task</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="POST" action="{{ route('tasks.update', $task->id) }}">
            @csrf @method('PUT')
            <div class="modal-body">
              <div class="mb-3">
                <label class="form-label">Task Name</label>
                <input type="text" class="form-control" name="name" value="{{ $task->name }}" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Assigned To</label>
                <select class="form-control" name="assigned_to" required >
                  @foreach ($employees as $employee)
                    <option value="{{ $employee->id }}" {{ $task->assigned_to == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" name="description" rows="6">{{ $task->description }}</textarea>
              </div>
              <div class="mb-3">
                <label class="form-label">Status</label>
                <select class="form-control" name="status">
                  <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                  <option value="In Progress" {{ $task->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                  <option value="Approval" {{ $task->status == 'Approval' ? 'selected' : '' }}>To Approval</option>
                  <option value="Done" {{ $task->status == 'Done' ? 'selected' : '' }}>Done</option>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">Priority</label>
                <select class="form-control" name="priority">
                  <option value="Low" {{ $task->priority == 'Low' ? 'selected' : '' }}>Low</option>
                  <option value="Medium" {{ $task->priority == 'Medium' ? 'selected' : '' }}>Medium</option>
                  <option value="High" {{ $task->priority == 'High' ? 'selected' : '' }}>High</option>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">Start Date</label>
                <input type="date" class="form-control" name="start_date" value="{{ $task->start_date }}">
              </div>
              <div class="mb-3">
                <label class="form-label">Due Date</label>
                <input type="date" class="form-control" name="due_date" value="{{ $task->due_date }}">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Update Task</button>
            </div>
          </form>
        </div></div>
      </div>

      {{-- Update Modal --}}
      <div class="modal fade" id="updateTaskModal-{{ $task->id }}" tabindex="-1" aria-labelledby="updateTaskModalLabel-{{ $task->id }}" aria-hidden="true">
        <div class="modal-dialog"><div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="updateTaskModalLabel-{{ $task->id }}">Update Task: {{ $task->name }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <h6>📌 Previous Updates:</h6>
            <ul class="list-group mb-3">
              @foreach($task->updates as $update)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  <div>
                    <strong>{{ $update->employee->name }} ({{ ucfirst($update->type) }})</strong><br>
                    {{ $update->update_text }}
                    <br><small>🕒 {{ $update->created_at->format('Y-m-d H:i') }}</small>
                  </div>
                  @if($update->is_solved)
                    <span class="text-success fw-bold">✅ Solved</span>
                  @elseif(Auth::user()->role->name === 'Admin' || Auth::user()->role->name === 'Manager')
                    <form method="POST" action="{{ route('tasks.solveUpdate', $update->id) }}">
                      @csrf
                      <button type="submit" class="btn btn-sm btn-success">✔ Mark as Solved</button>
                    </form>
                  @endif
                </li>
              @endforeach
            </ul>

            <form method="POST" action="{{ route('tasks.addUpdate', $task->id) }}">
              @csrf
              <div class="mb-3">
                <label class="form-label">Update Type</label>
                <select class="form-control" name="type" required>
                  <option value="progress">✅ Progress</option>
                  <option value="problem">❌ Problem</option>
                  <option value="requirement">📄 Missing Requirement</option>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">Your Update</label>
                <textarea class="form-control" name="update_text" required placeholder="Describe the issue, requirement, or progress..."></textarea>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit Update</button>
              </div>
            </form>
          </div>
        </div></div>
      </div>
    @endforeach
  </ul>
</div>

<!-- Add Task Modal (unchanged) -->
<div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
  <div class="modal-dialog"><div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="addTaskModalLabel">Add New Task</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form method="POST" action="{{ route('tasks.store') }}">
      @csrf
      <input type="hidden" name="sprint_id" value="{{ $sprint->id }}">
      <input type="hidden" name="project_id" value="{{ $sprint->project_id }}">
      <div class="modal-body">
        <div class="mb-3"><label class="form-label">Task Name</label><input type="text" class="form-control" name="name" required></div>
        <div class="mb-3"><label class="form-label">Assigned To</label>
          <select class="form-control" name="assigned_to" required>
            @foreach ($employees as $employee)
              <option value="{{ $employee->id }}">{{ $employee->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3"><label class="form-label">Description</label><textarea class="form-control" name="description" rows="6"></textarea></div>
        <div class="mb-3"><label class="form-label">Status</label>
          <select class="form-control" name="status">
            <option value="Pending">Pending</option>
            <option value="In Progress">In Progress</option>
            <option value="Done">Done</option>
          </select>
        </div>
        <div class="mb-3"><label class="form-label">Priority</label>
          <select class="form-control" name="priority">
            <option value="Low">Low</option>
            <option value="Medium">Medium</option>
            <option value="High">High</option>
          </select>
        </div>
        <div class="mb-3"><label class="form-label">Start Date</label><input type="date" class="form-control" name="start_date"></div>
        <div class="mb-3"><label class="form-label">Due Date</label><input type="date" class="form-control" name="due_date"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save Task</button>
      </div>
    </form>
  </div></div>
</div>
@endsection


<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const list = document.getElementById('taskList');
  const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  const reorderUrl = "{{ route('tasks.reorder') }}";
  const sprintId = "{{ $sprint->id }}";

  function currentOrder() {
    return Array.from(list.querySelectorAll('li[data-id]')).map(li => Number(li.dataset.id));
  }

  async function saveOrder() {
    const payload = { sprint_id: Number(sprintId), order: currentOrder() };
    try {
      const res = await fetch(reorderUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': token,
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json'
        },
        body: JSON.stringify(payload),
        credentials: 'same-origin'
      });
      const text = await res.text();
      let json = null; try { json = JSON.parse(text); } catch {}
      if (!res.ok) {
        console.error('Reorder failed', res.status, json || text);
        alert('Could not save new order. Status: ' + res.status);
        return;
      }
      // console.log('Order saved:', json);
    } catch (e) {
      console.error('Fetch error:', e);
      alert('Network error while saving order.');
    }
  }

  new Sortable(list, {
    animation: 150,
    handle: '.drag-handle',
    ghostClass: 'sorting-ghost',
    dragClass: 'sorting-drag',
    filter: 'button, a, input, textarea, select, label, form',
    preventOnFilter: false,
    onEnd: saveOrder,
    onMove: function (evt) {
      if (evt.originalEvent && evt.originalEvent.target.closest('button, a, input, textarea, select, label, form')) {
        return false;
      }
    }
  });
});
</script>
<style>
.sorting-ghost { opacity: .5; }
.sorting-drag  { transform: rotate(1deg); }
</style>

