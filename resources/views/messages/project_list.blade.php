@extends('AdminDashboard.master')

@section('title', 'Messages')

@section('content')

<div class="container-fluid">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="mb-0">Project Messages</h4>
            </div>
            <div class="col-md-6 text-end">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('frontend/assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumb-item">Messages</li>
                    <li class="breadcrumb-item active">Projects</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Container-fluid starts-->
<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header pb-0">
            <h4 class="card-title mb-0">Choose a Project for Messages</h4>
        </div>
        <div class="card-body pt-3">
            <div class="row">
                @forelse ($projects as $project)
                <div class="col-md-3 mb-4">
                    <a href="{{ route('messages.index', ['project' => $project->id]) }}" class="text-decoration-none text-dark">
                        <div class="card h-100 border-0 shadow-sm hover-shadow border-start border-4 border-primary">
                            <div class="card-body">
                                <h5 class="fw-semibold text-primary mb-2">{{ $project->name }}</h5>
                                <p class="mb-1"><strong>Start Date:</strong> {{ $project->start_date }}</p>
                                <p class="mb-1"><strong>Deadline:</strong> {{ $project->deadline }}</p>
                                <p class="mb-0"><strong>Status:</strong>
                                    @if ($project->status === 'Completed')
                                        <span class="badge bg-success">{{ $project->status }}</span>
                                    @elseif ($project->status === 'In Progress')
                                        <span class="badge bg-warning text-dark">{{ $project->status }}</span>
                                    @elseif ($project->status === 'On Hold')
                                        <span class="badge bg-secondary">{{ $project->status }}</span>
                                    @elseif ($project->status === 'Cancelled')
                                        <span class="badge bg-danger">{{ $project->status }}</span>
                                    @else
                                        <span class="badge bg-primary">{{ $project->status }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info">No projects found.</div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
    .hover-shadow:hover {
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.15) !important;
        transition: box-shadow 0.3s ease;
    }
</style>

@endsection
