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
              <div class="card-options">
                <a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                <a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a>
              </div>
            </div>

            <div class="card-body">
              <div class="row">

                <div class="col-12">
                  <h6 class="mb-3 text-primary">Client Details</h6>
                </div>

                <div class="col-md-12 mb-3">
                  <label class="form-label">Client *</label>
                  <select name="client_id" class="form-control btn-square" required>
                    <option value="">-- Select Client --</option>
                    @foreach ($clients as $client)
                      <option value="{{ $client->id }}" {{ $project->client_id == $client->id ? 'selected' : '' }}>
                        {{ $client->name }}
                      </option>
                    @endforeach
                  </select>
                </div>

                <div class="col-12">
                  <h6 class="mb-3 mt-1 text-primary">Project Details</h6>
                </div>

                <div class="col-md-6 mb-3">
                  <label class="form-label">Project Name *</label>
                  <input class="form-control" type="text" name="name" value="{{ $project->name }}" required>
                </div>

                <div class="col-md-6 mb-3">
                  <label class="form-label">Category *</label>
                  <select name="category_id" class="form-control btn-square" required>
                    <option value="">-- Select Category --</option>
                    @foreach ($categories as $category)
                      <option value="{{ $category->id }}" {{ $project->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                      </option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-12 mb-3">
                  <label class="form-label">Description</label>
                  <textarea class="form-control" name="description">{{ $project->description }}</textarea>
                </div>

                <div class="col-md-6 mb-3">
                  <label class="form-label">Start Date *</label>
                  <input class="form-control" type="date" name="start_date" value="{{ $project->start_date }}" required>
                </div>

                <div class="col-md-6 mb-3">
                  <label class="form-label">Deadline *</label>
                  <input class="form-control" type="date" name="deadline" value="{{ $project->deadline }}" required>
                </div>

                <div class="col-md-6 mb-3">
                  <label class="form-label">Status *</label>
                  <select class="form-control btn-square" name="status" required>
                    @foreach (['New', 'In Progress', 'Completed', 'On Hold', 'Cancelled'] as $status)
                      <option value="{{ $status }}" {{ $project->status == $status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-6 mb-3">
                  <label class="form-label">Priority *</label>
                  <select class="form-control btn-square" name="priority" required>
                    @foreach (['Low', 'Medium', 'High'] as $priority)
                      <option value="{{ $priority }}" {{ $project->priority == $priority ? 'selected' : '' }}>{{ $priority }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-6 mb-3">
                  <label class="form-label">Estimated Budget</label>
                  <input class="form-control" type="number" name="estimate_budget" step="0.01" value="{{ $project->estimate_budget }}">
                </div>

                <div class="col-md-6 mb-3">
                  <label class="form-label">Attachment</label>
                  <input class="form-control" type="file" name="attachment">
                </div>

                <div class="col-md-12 mb-3">
                  <label class="form-label">Additional Note</label>
                  <textarea class="form-control" name="additional_note">{{ $project->additional_note }}</textarea>
                </div>

                <div class="col-12">
                  <h6 class="mb-3 mt-1 text-primary">Authorized Person Details</h6>
                </div>

                <div class="col-md-12">
                  <div id="authorized-persons-wrapper">
                    @foreach($project->authorizedPersons as $index => $person)
                      <div class="authorized-person border p-3 mb-3 position-relative">
                        @if($index > 0)
                          <button type="button" class="btn-close position-absolute top-0 end-0 m-2 remove-person-btn" aria-label="Close"></button>
                        @endif
                        <div class="row">
                          <div class="col-md-3 mb-3">
                            <label class="form-label">Name *</label>
                            <input type="text" name="authorized_persons[{{ $index }}][name]" class="form-control" value="{{ $person->name }}" required>
                          </div>
                          <div class="col-md-3 mb-3">
                            <label class="form-label">Designation *</label>
                            <input type="text" name="authorized_persons[{{ $index }}][designation]" class="form-control" value="{{ $person->designation }}" required>
                          </div>
                          <div class="col-md-3 mb-3">
                            <label class="form-label">Contact *</label>
                            <input type="text" name="authorized_persons[{{ $index }}][contact]" class="form-control" value="{{ $person->contact }}" required>
                          </div>
                          <div class="col-md-3 mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" name="authorized_persons[{{ $index }}][email]" class="form-control" value="{{ $person->email }}" required>
                          </div>
                        </div>
                      </div>
                    @endforeach
                  </div>

                  <button type="button" class="btn btn-outline-primary btn-sm" id="add-person-btn">
                    + Add Another Authorized Person
                  </button>
                </div>

                <!-- Assign Employees Section -->
                  <div class="col-md-12 mt-5 mb-3">
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
                    <p>Assigned Employees:</p>
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
  let personIndex = {{ count($project->authorizedPersons) }};

  document.getElementById('add-person-btn').addEventListener('click', function () {
    const wrapper = document.getElementById('authorized-persons-wrapper');
    const div = document.createElement('div');
    div.className = 'authorized-person border p-3 mb-3 position-relative';
    div.innerHTML = `
      <button type="button" class="btn-close position-absolute top-0 end-0 m-2 remove-person-btn" aria-label="Close"></button>
      <div class="row">
        <div class="col-md-3 mb-3">
          <label class="form-label">Name *</label>
          <input type="text" name="authorized_persons[${personIndex}][name]" class="form-control" required>
        </div>
        <div class="col-md-3 mb-3">
          <label class="form-label">Designation *</label>
          <input type="text" name="authorized_persons[${personIndex}][designation]" class="form-control" required>
        </div>
        <div class="col-md-3 mb-3">
          <label class="form-label">Contact *</label>
          <input type="text" name="authorized_persons[${personIndex}][contact]" class="form-control" required>
        </div>
        <div class="col-md-3 mb-3">
          <label class="form-label">Email *</label>
          <input type="email" name="authorized_persons[${personIndex}][email]" class="form-control" required>
        </div>
      </div>
    `;
    wrapper.appendChild(div);
    personIndex++;
  });

  document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-person-btn')) {
      e.target.closest('.authorized-person').remove();
    }
  });


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
