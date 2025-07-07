@extends('AdminDashboard.master')

@section('title', 'Project List')

@section('content')

<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row project-cards">
        <div class="col-md-12 project-list">
            <div class="header-wrapper row m-0">
                <div class="col-6">
                    <h3 style="margin-top:50px; margin-bottom: 20px;">Project List</h3>
                </div>

                {{-- ✅ Show "Create New Project" button only for Admin & Manager --}}
                @if(Auth::user()->role->name === 'Admin' || Auth::user()->role->name === 'Manager')
                    <div class="col-md-6 text-end">
                        <a class="btn btn-primary" href="{{ route('projects.create') }}"> 
                            <i data-feather="plus-square"></i> Create New Project
                        </a>
                    </div>
                @endif
            </div>

            <div class="card">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="nav nav-tabs border-tab" id="top-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="top-home-tab" data-bs-toggle="tab" href="#top-home" role="tab">
                                    <i data-feather="target"></i> All
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-top-tab" data-bs-toggle="tab" href="#top-profile" role="tab">
                                    <i data-feather="info"></i> Doing
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="contact-top-tab" data-bs-toggle="tab" href="#top-contact" role="tab">
                                    <i data-feather="check-circle"></i> Completed
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        @foreach ($projects as $project)
        <div class="col-xxl-4 col-md-6">
            <div class="project-box" style="border: {{ ($project->deadline < now() && $project->status != 'Completed') ? '2px solid red' : 'none' }};">
                <span class="badge {{ $project->status == 'Completed' ? 'badge-success' : 'badge-primary' }}">{{ $project->status }}</span>
                <h6>{{ $project->name }}</h6>

                <!-- Display Project Owner(s) -->
                <div class="media">
                    <img class="img-20 me-1 rounded-circle" src="{{ asset('frontend/assets/images/user/user.png') }}" alt="">
                    <div class="media-body">
                        <p> {{ $project->ownerNames }}</p>
                    </div>
                </div>

                <p>{{ Str::limit($project->description, 100) }}</p>

                <div class="row details">
                    <div class="col-6"><span>Start Date</span></div>
                    <div class="col-6 text-primary">{{ $project->start_date }}</div>
                </div>
                <div class="row details">
                    <div class="col-6"><span>Deadline</span></div>
                    <div class="col-6 text-primary">{{ $project->deadline }}</div>
                </div>

                <!-- Project Progress -->
                <div class="project-status mt-4">
                    <div class="row">
                        <div class="col-6">
                            <p><strong>Tasks:</strong> {{ $project->tasks_count }} | {{ $project->completed_tasks }}</p>
                        </div>
                        <div class="col-6 text-end">
                            <p><strong>{{ $project->progress }}% Complete</strong></p>
                        </div>
                    </div>
                    <div class="progress" style="height: 5px">
                        <div class="progress-bar" role="progressbar"
                            style="width: {{ $project->progress }}%; background-color: {{ $project->progress == 100 ? 'green' : 'blue' }};"
                            aria-valuenow="{{ $project->progress }}" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-3">
                    <a href="{{ route('kanban.board', ['project_id' => $project->id]) }}" class="btn btn-blue btn-sm" style="background-color: blue; color: white; width: 100px;">Kanban</a>
                    <a href="{{ route('sprints.index', ['project_id' => $project->id]) }}" class="btn btn-secondary btn-sm" style="width: 100px;">Sprints</a>

                    {{-- ✅ Show "Edit" & "Delete" buttons only for Admin & Manager --}}
                    @if(Auth::user()->role->name === 'Admin' || Auth::user()->role->name === 'Manager')
                        <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-warning btn-sm" style="width: 100px;">
                            <i class="icon-pencil-alt"></i>
                        </a>
                        <form action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" style="width: 100px;" onclick="return confirm('Are you sure?')">
                                <i class="icon-trash"></i>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
