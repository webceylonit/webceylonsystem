@extends('AdminDashboard.master')

@section('title', 'Messages')

@section('content')

<div class="container-fluid">
    <div class="page-title mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="fw-bold">💬 Project Messages</h4>
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

<!-- Stylish Project Grid -->
<div class="container-fluid">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 pb-0">
            <h5 class="card-title mb-0 fw-semibold">Select a Project to Start Messaging</h5>
        </div>
        <div class="card-body pt-4">
            <div class="row g-4">
                @forelse ($projects as $project)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="glass-card shadow-sm">
                        <div class="top-border-accent"></div>
                        <div class="card-body d-flex flex-column h-100">
                            <!-- 💡 Title without bold -->
                            <h5 class="text-dark mb-2" style="font-weight: 500;">{{ $project->name }}</h5>
                            <div class="mb-3">
                                @php
                                    $statusClass = match($project->status) {
                                        'Completed' => 'success',
                                        'In Progress' => 'warning text-dark',
                                        'On Hold' => 'secondary',
                                        'Cancelled' => 'danger',
                                        default => 'primary'
                                    };
                                @endphp
                                <span class="badge rounded-pill bg-{{ $statusClass }}">{{ $project->status }}</span>
                            </div>
                            <div class="mt-auto">
                                <a href="{{ route('messages.index', ['project' => $project->id]) }}"
                                   class="btn btn-sm btn-gradient w-100">
                                   📥 View Messages
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info">No projects available.</div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.8);
        border-radius: 0.75rem;
        backdrop-filter: blur(5px);
        border: 1px solid rgba(0, 0, 0, 0.05);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
        transition: all 0.3s ease;
    }

    .glass-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }

    .top-border-accent {
        height: 4px;
        background: linear-gradient(to right, #0d6efd, #6610f2);
        border-top-left-radius: 0.75rem;
        border-top-right-radius: 0.75rem;
    }

    .btn-gradient {
        background: linear-gradient(to right, #0d6efd, #6610f2);
        color: #fff;
        border: none;
        transition: 0.3s ease;
    }

    .btn-gradient:hover {
        background: linear-gradient(to right, #6610f2, #0d6efd);
        color: #fff;
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.4em 0.75em;
    }

    @media (max-width: 576px) {
        .glass-card h5 {
            font-size: 1rem;
        }
    }
</style>

@endsection
