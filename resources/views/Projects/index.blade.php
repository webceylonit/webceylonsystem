@extends('AdminDashboard.master')

@section('title', 'Project List')

@section('content')

<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h4>Project List</h4>
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
                    <li class="breadcrumb-item active">Projects</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row project-cards">
        <div class="col-md-12 project-list">
            <div class="header-wrapper row m-0">
                <!-- <div class="col-6">
                    <h3 style="margin-top:50px; margin-bottom: 20px;">Project List</h3>
                </div> -->

                {{-- ✅ Show "Create New Project" button only for Admin & Manager --}}
                 
                <div class="col-md-12 text-end mb-3">
                    <a class="btn btn-primary" href="{{ route('projects.create') }}">
                        <i data-feather="plus-square"></i> Create New Project
                    </a>
                </div>
                
            </div>

            <div class="card ">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="nav nav-tabs border-tab" id="top-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="all-tab" data-bs-toggle="tab" href="#all-projects" role="tab">
                                    <i data-feather="target"></i> All
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="new-tab" data-bs-toggle="tab" href="#new-projects" role="tab">
                                    <i data-feather="info"></i> New
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="inprogress-tab" data-bs-toggle="tab" href="#inprogress-projects" role="tab">
                                    <i data-feather="edit"></i> In-Progress
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="completed-tab" data-bs-toggle="tab" href="#completed-projects" role="tab">
                                    <i data-feather="check-circle"></i> Completed
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-content mt-3">
            <!-- All Projects -->
            <div class="tab-pane fade show active" id="all-projects" role="tabpanel">
                <div class="row">
                    @foreach ($projects as $project)
                    @include('Projects.partials.project-box', ['project' => $project])
                    @endforeach
                </div>
            </div>

            <!-- New Projects -->
            <div class="tab-pane fade" id="new-projects" role="tabpanel">
                <div class="row">
                    @foreach ($projects->where('status', 'New') as $project)
                    @include('Projects.partials.project-box', ['project' => $project])
                    @endforeach
                </div>
            </div>

            <!-- In-Progress Projects -->
            <div class="tab-pane fade" id="inprogress-projects" role="tabpanel">
                <div class="row">
                    @foreach ($projects->where('status', 'In Progress') as $project)
                    @include('Projects.partials.project-box', ['project' => $project])
                    @endforeach
                </div>
            </div>

            <!-- Completed Projects -->
            <div class="tab-pane fade" id="completed-projects" role="tabpanel">
                <div class="row">
                    @foreach ($projects->where('status', 'Completed') as $project)
                    @include('Projects.partials.project-box', ['project' => $project])
                    @endforeach
                </div>
            </div>
        </div>



    </div>
</div>

@endsection