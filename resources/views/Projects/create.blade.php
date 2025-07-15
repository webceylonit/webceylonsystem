@extends('AdminDashboard.master')

@section('title', 'Create Project')

@section('content')

<div class="container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-6">
        <h4>Create Project</h4>
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
          <li class="breadcrumb-item active">Create Project</li>
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
          <form class="card" method="POST" action="{{ route('projects.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-header">
              <h4 class="card-title mb-0">Create Project</h4>
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
                  <select name="client_id" class="form-control btn-square" id="client-select" required>
                    <option value="">-- Select Client --</option>
                    @foreach ($clients as $client)
                    <option value="{{ $client->id }}" {{ (old('client_id') ?? $selectedClientId) == $client->id ? 'selected' : '' }}>
                      {{ $client->name }}
                    </option>
                    @endforeach
                  </select>
                  @error('client_id')
                  <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>

                <div class="col-12">
                  <h6 class="mb-3 mt-1 text-primary">Project Details</h6>
                </div>


                <div class="col-md-6 mb-3">
                  <label class="form-label">Project Name *</label>
                  <input class="form-control" type="text" name="name" placeholder="Project Name" value="{{ old('name') }}" required>
                  @error('name')
                  <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>

                <div class="col-md-6 mb-3">
                  <label class="form-label">Category *</label>
                  <select name="category_id" class="form-control btn-square" required>
                    <option value="">-- Select Category --</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                  </select>
                  @error('category_id')
                  <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>

                <div class="col-md-12 mb-3">
                  <label class="form-label">Description</label>
                  <textarea class="form-control" name="description" placeholder="Project Description">{{ old('description') }}</textarea>
                  @error('description')
                  <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>

                <div class="col-md-6 mb-3">
                  <label class="form-label">Start Date *</label>
                  <input class="form-control" type="date" name="start_date" value="{{ old('start_date') }}" required>
                  @error('start_date')
                  <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>

                <div class="col-md-6 mb-3">
                  <label class="form-label">Deadline *</label>
                  <input class="form-control" type="date" name="deadline" value="{{ old('deadline') }}" required>
                  @error('deadline')
                  <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>

                <div class="col-md-6 mb-3">
                  <label class="form-label">Status *</label>
                  <select class="form-control btn-square" name="status" required>
                    <option value="New" {{ old('status') == 'New' ? 'selected' : '' }}>New</option>
                    <option value="In Progress" {{ old('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                    <option value="On Hold" {{ old('status') == 'On Hold' ? 'selected' : '' }}>On Hold</option>
                    <option value="Cancelled" {{ old('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                  </select>
                  @error('status')
                  <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>

                <div class="col-md-6 mb-3">
                  <label class="form-label">Priority *</label>
                  <select class="form-control btn-square" name="priority" required>
                    <option value="Low" {{ old('priority') == 'Low' ? 'selected' : '' }}>Low</option>
                    <option value="Medium" {{ old('priority') == 'Medium' ? 'selected' : '' }}>Medium</option>
                    <option value="High" {{ old('priority') == 'High' ? 'selected' : '' }}>High</option>
                  </select>
                  @error('priority')
                  <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>

                <div class="col-md-6 mb-3">
                  <label class="form-label">Estimated Budget</label>
                  <input class="form-control" type="number" name="estimate_budget" placeholder="Estimated Budget" step="0.01" value="{{ old('estimate_budget') }}">
                  @error('estimate_budget')
                  <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>

                <div class="col-md-6 mb-3">
                  <label class="form-label">Attachment (Optional)</label>
                  <input class="form-control" type="file" name="attachment">
                  @error('attachment')
                  <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>

                <div class="col-md-12 mb-3">
                  <label class="form-label">Additional Note</label>
                  <textarea class="form-control" name="additional_note" placeholder="Additional notes...">{{ old('additional_note') }}</textarea>
                  @error('additional_note')
                  <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>



                <div class="col-12">
                  <h6 class="mb-3 mt-1 text-primary">Authorized Person Details</h6>
                </div>

                <div class="col-md-12">
                  <div id="authorized-persons-wrapper">
                    <div class="authorized-person border p-3 mb-3 position-relative">
                      <h6 class="text-secondary">Authorized Person</h6>

                      <div class="row">
                        <div class="col-md-3 mb-3">
                          <label class="form-label">Name *</label>
                          <input type="text" name="authorized_persons[0][name]" class="form-control" required>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label class="form-label">Designation *</label>
                          <input type="text" name="authorized_persons[0][designation]" class="form-control" required>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label class="form-label">Contact *</label>
                          <input type="text" name="authorized_persons[0][contact]" class="form-control" required>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label class="form-label">Email *</label>
                          <input type="email" name="authorized_persons[0][email]" class="form-control" required>
                        </div>
                      </div>
                    </div>
                  </div>

                  <button type="button" class="btn btn-outline-primary btn-sm" id="add-person-btn">
                    + Add Another Authorized Person
                  </button>
                </div>


              </div>
            </div>

            <div class="card-footer text-end">
              <button class="btn btn-primary" type="submit">Create Project</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>


<script>
  let personIndex = 1;

  document.getElementById('add-person-btn').addEventListener('click', function() {
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

  document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-person-btn')) {
      e.target.closest('.authorized-person').remove();
    }
  });
</script>



@endsection