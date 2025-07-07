@extends('AdminDashboard.master')

@section('title', 'Edit Project')

@section('content')
<div class="container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-6">
        <h4>Edit Project</h4>
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
          <li class="breadcrumb-item">Projects</li>
          <li class="breadcrumb-item active">Edit Project</li>
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
            <form class="card" method="POST" action="{{ route('projects.update', $project->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-header">
                  <h4 class="card-title mb-0">Edit Project</h4>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12 mb-3">
                      <label class="form-label">Project Name</label>
                      <input class="form-control" type="text" name="name" value="{{ old('name', $project->name) }}">
                      @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                      <label class="form-label">Description</label>
                      <textarea class="form-control" name="description">{{ old('description', $project->description) }}</textarea>
                      @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                      <label class="form-label">Start Date</label>
                      <input class="form-control" type="date" name="start_date" value="{{ old('start_date', $project->start_date) }}">
                      @error('start_date') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                      <label class="form-label">Deadline</label>
                      <input class="form-control" type="date" name="deadline" value="{{ old('deadline', $project->deadline) }}">
                      @error('deadline') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                      <label class="form-label">Status</label>
                      <select class="form-control btn-square" name="status">
                        <option value="New" {{ old('status', $project->status) == 'New' ? 'selected' : '' }}>New</option>
                        <option value="In Progress" {{ old('status', $project->status) == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="Completed" {{ old('status', $project->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                      </select>
                      @error('status')
                        <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                      <label class="form-label">Priority</label>
                      <select class="form-control btn-square" name="priority">
                        <option value="Low" {{ old('priority', $project->priority) == 'Low' ? 'selected' : '' }}>Low</option>
                        <option value="Medium" {{ old('priority', $project->priority) == 'Medium' ? 'selected' : '' }}>Medium</option>
                        <option value="High" {{ old('priority', $project->priority) == 'High' ? 'selected' : '' }}>High</option>
                      </select>
                      @error('priority')
                        <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>

                    <h5 class="col-md-12 mb-3 mt-3">Assigne Employees</h5>
                  
                  <!-- Assign Employees Section -->
                  <div class="col-md-12 mb-3">
                    <label class="form-label">Assign Employees</label>
                    <select class="form-control" id="employee-dropdown">
                      <option value="">Select Employee</option>
                      @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" data-name="{{ $employee->name }}" {{ in_array($employee->id, $assignedEmployees) ? 'disabled' : '' }}>
                          {{ $employee->name }}
                        </option>
                      @endforeach
                    </select>
                  </div>

                  <div class="col-md-12 mb-3">
                    <p>Assigned Employees</p>
                    <ul id="assigned-employees" class="list-group">
                      @foreach($project->employees as $employee)
                        <li class="list-group-item d-flex justify-content-between align-items-center" data-id="{{ $employee->id }}">
                          {{ $employee->name }}
                          <input type="hidden" name="employees[]" value="{{ $employee->id }}">
                          <button type="button" class="btn btn-danger btn-sm remove-employee">Remove</button>
                        </li>
                      @endforeach
                    </ul>
                  </div>

                    
                  </div>

                </div>
                <div class="card-footer text-end">
                  <button class="btn btn-primary" type="submit">Update Project</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", function() {
  let employeeDropdown = document.getElementById("employee-dropdown");
  let assignedList = document.getElementById("assigned-employees");
  
  employeeDropdown.addEventListener("change", function() {
    let selectedOption = employeeDropdown.options[employeeDropdown.selectedIndex];
    let employeeId = selectedOption.value;
    let employeeName = selectedOption.getAttribute("data-name");
    
    if (employeeId) {
      let listItem = document.createElement("li");
      listItem.classList.add("list-group-item", "d-flex", "justify-content-between", "align-items-center");
      listItem.setAttribute("data-id", employeeId);
      listItem.innerHTML = `${employeeName} 
        <input type='hidden' name='employees[]' value='${employeeId}'>
        <button type='button' class='btn btn-danger btn-sm remove-employee'>Remove</button>`;
      
      assignedList.appendChild(listItem);
      selectedOption.disabled = true;
    }
  });

  assignedList.addEventListener("click", function(e) {
    if (e.target.classList.contains("remove-employee")) {
      let listItem = e.target.closest("li");
      let employeeId = listItem.getAttribute("data-id");
      
      listItem.remove();
      document.querySelector(`#employee-dropdown option[value='${employeeId}']`).disabled = false;
    }
  });
});
</script>

@endsection

