@extends('AdminDashboard.master')

@section('title', 'Tasks for Sprint: ' . $sprint->name)

@section('content')
<div class="container-fluid pt-2">
  <div class="page-title">
    <div class="row">
      <div class="col-6">
        <h4>Tasks for {{ $sprint->name }}</h4>
      </div>
      <div class="col-6 text-end">
        <a href="{{ route('sprints.index', ['project_id' => $sprint->project_id]) }}" class="btn btn-secondary">← Back to Sprint</a>
        {{-- ✅ Only Admin & Manager Can Add Tasks --}}
        @if(Auth::user()->role->name === 'Admin' || Auth::user()->role->name === 'Manager')
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTaskModal">+ Add Task</button>
        @endif
      </div>
    </div>
  </div>
</div>

<!-- Task List -->
<div class="container-fluid">
  <ul class="list-group">
    @foreach ($tasks as $task)
      <li class="list-group-item d-flex justify-content-between align-items-center mb-1" style="border: {{ ($task->due_date < now() && $task->status != 'Done') ? '2px solid red' : 'none' }};">
        <div>
          <h6 class="mb-1">{{ $task->name }}</h6>
          <small>Assigned to: {{ $task->assignedTo->name }}</small><br>
          <small>Status: <span class="badge {{ $task->status == 'Done' ? 'bg-success' : ($task->status == 'In Progress' ? 'bg-warning' : 'bg-secondary') }}">
            {{ $task->status }}
          </span></small>
        </div>
        <div>
          <!-- Open Task Update Modal -->
          <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#updateTaskModal-{{ $task->id }}">Requirements</button>

          <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editTaskModal-{{ $task->id }}">Edit</button>
          @if(Auth::user()->role->name === 'Admin' || Auth::user()->role->name === 'Manager')
          <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
          </form>
          @endif
        </div>
      </li>

      <!-- Edit Task Modal (Inside Loop) -->
      <div class="modal fade" id="editTaskModal-{{ $task->id }}" tabindex="-1" aria-labelledby="editTaskModalLabel-{{ $task->id }}" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editTaskModalLabel-{{ $task->id }}">Edit Task</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('tasks.update', $task->id) }}">
              @csrf
              @method('PUT')
              <div class="modal-body">
                <div class="mb-3">
                  <label class="form-label">Task Name</label>
                  <input type="text" class="form-control" name="name" value="{{ $task->name }}" required>
                </div>
                {{-- ✅ Only Admin & Manager Can Edit "Assigned To" --}}
                <div class="mb-3">
                  <label class="form-label">Assigned To</label>
                  <select class="form-control" name="assigned_to" required {{ Auth::user()->role->name !== 'Admin' && Auth::user()->role->name !== 'Manager' ? 'disabled' : '' }}>
                    @foreach ($employees as $employee)
                      <option value="{{ $employee->id }}" {{ $task->assigned_to == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="mb-3">
                  <label class="form-label">Description</label>
                  <textarea class="form-control" name="description">{{ $task->description }}</textarea>
                </div>
                <div class="mb-3">
                  <label class="form-label">Status</label>
                  <select class="form-control" name="status">
                    <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="In Progress" {{ $task->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
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
                {{-- ✅ Only Admin & Manager Can Edit "Start Date" & "Due Date" --}}
                <div class="mb-3">
                  <label class="form-label">Start Date</label>
                  <input type="date" class="form-control" name="start_date" value="{{ $task->start_date }}" {{ Auth::user()->role->name !== 'Admin' && Auth::user()->role->name !== 'Manager' ? 'disabled' : '' }}>
                </div>
                <div class="mb-3">
                  <label class="form-label">Due Date</label>
                  <input type="date" class="form-control" name="due_date" value="{{ $task->due_date }}" {{ Auth::user()->role->name !== 'Admin' && Auth::user()->role->name !== 'Manager' ? 'disabled' : '' }}>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update Task</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- ✅ Task Update Modal -->
      <!-- ✅ Task Update Modal (Show Previous Updates) -->
<div class="modal fade" id="updateTaskModal-{{ $task->id }}" tabindex="-1" aria-labelledby="updateTaskModalLabel-{{ $task->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateTaskModalLabel-{{ $task->id }}">Update Task: {{ $task->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <!-- 🔹 Show Previous Updates -->
                <h6>📌 Previous Updates:</h6>
                <ul class="list-group mb-3">
                    @foreach($task->updates as $update)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $update->employee->name }} ({{ ucfirst($update->type) }})</strong><br>
                                {{ $update->update_text }}
                                <br><small>🕒 {{ $update->created_at->format('Y-m-d H:i') }}</small>
                            </div>
                            
                            <!-- ✅ If Solved, Show Green Tick -->
                            @if($update->is_solved)
                                <span class="text-success fw-bold">✅ Solved</span>
                            @elseif(Auth::user()->role->name === 'Admin' || Auth::user()->role->name === 'Manager')
                                <!-- 🔹 "Mark as Solved" Button (Only for Admin/Manager) -->
                                <form method="POST" action="{{ route('tasks.solveUpdate', $update->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">✔ Mark as Solved</button>
                                </form>
                            @endif
                        </li>
                    @endforeach
                </ul>


                <!-- 🔹 Add New Update -->
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
        </div>
    </div>
</div>

    @endforeach
  </ul>
</div>

<!-- Add Task Modal -->
@if(Auth::user()->role->name === 'Admin' || Auth::user()->role->name === 'Manager')
<div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addTaskModalLabel">Add New Task</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="{{ route('tasks.store') }}">
        @csrf
        <input type="hidden" name="sprint_id" value="{{ $sprint->id }}">
        <input type="hidden" name="project_id" value="{{ $sprint->project_id }}">
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Task Name</label>
            <input type="text" class="form-control" name="name" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Assigned To</label>
            <select class="form-control" name="assigned_to" required>
              @foreach ($employees as $employee)
                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Status</label>
            <select class="form-control" name="status">
              <option value="Pending">Pending</option>
              <option value="In Progress">In Progress</option>
              <option value="Done">Done</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Priority</label>
            <select class="form-control" name="priority">
              <option value="Low">Low</option>
              <option value="Medium">Medium</option>
              <option value="High">High</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Start Date</label>
            <input type="date" class="form-control" name="start_date">
          </div>
          <div class="mb-3">
            <label class="form-label">Due Date</label>
            <input type="date" class="form-control" name="due_date">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save Task</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endif
@endsection




