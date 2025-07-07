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
                <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
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

<!-- Container-fluid starts-->
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
                    <div class="col-md-12 mb-3">
                      <label class="form-label">Project Name</label>
                      <input class="form-control" type="text" name="name" placeholder="Project Name" value="{{ old('name') }}">
                      @error('name')
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
                      <label class="form-label">Start Date</label>
                      <input class="form-control" type="date" name="start_date" value="{{ old('start_date') }}">
                      @error('start_date')
                        <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label">Deadline</label>
                      <input class="form-control" type="date" name="deadline" value="{{ old('deadline') }}">
                      @error('deadline')
                        <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label">Status</label>
                      <select class="form-control btn-square" name="status">
                        <option value="New" {{ old('status') == 'New' ? 'selected' : '' }}>New</option>
                        <option value="In Progress" {{ old('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                      </select>
                      @error('status')
                        <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label">Priority</label>
                      <select class="form-control btn-square" name="priority">
                        <option value="Low" {{ old('priority') == 'Low' ? 'selected' : '' }}>Low</option>
                        <option value="Medium" {{ old('priority') == 'Medium' ? 'selected' : '' }}>Medium</option>
                        <option value="High" {{ old('priority') == 'High' ? 'selected' : '' }}>High</option>
                      </select>
                      @error('priority')
                        <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                    <div class="col-md-12 mb-3">
                      <label class="form-label">Attachment (Optional)</label>
                      <input class="form-control" type="file" name="attachment">
                      @error('attachment')
                        <small class="text-danger">{{ $message }}</small>
                      @enderror
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

@endsection
