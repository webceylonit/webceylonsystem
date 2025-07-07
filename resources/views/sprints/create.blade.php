@extends('AdminDashboard.master')

@section('title', 'Create Sprint')

@section('content')
<div class="container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-6">
        <h4>Create Sprint</h4>
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
          <li class="breadcrumb-item">Sprints</li>
          <li class="breadcrumb-item active">Create Sprint</li>
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
            <form class="card" method="POST" action="{{ route('sprints.store') }}">
                @csrf
                <div class="card-header">
                  <h4 class="card-title mb-0">Create Sprint</h4>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12 mb-3">
                      <label class="form-label">Project</label>
                      <select class="form-control" name="project_id">
                        <option value="">Select Project</option>
                        @foreach($projects as $project)
                          <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                      </select>
                      @error('project_id')
                        <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                    <div class="col-md-12 mb-3">
                      <label class="form-label">Sprint Name</label>
                      <input class="form-control" type="text" name="name" placeholder="Sprint Name" value="{{ old('name') }}">
                      @error('name')
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
                      <label class="form-label">End Date</label>
                      <input class="form-control" type="date" name="end_date" value="{{ old('end_date') }}">
                      @error('end_date')
                        <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                    <div class="col-md-12 mb-3">
                      <label class="form-label">Status</label>
                      <select class="form-control" name="status">
                        <option value="Not Started" {{ old('status') == 'Not Started' ? 'selected' : '' }}>Not Started</option>
                        <option value="In Progress" {{ old('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                      </select>
                      @error('status')
                        <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="card-footer text-end">
                  <button class="btn btn-primary" type="submit">Create Sprint</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
