@extends('AdminDashboard.master')

@section('title', 'Projects')

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
                                <use href="{{ asset('frontend/assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumb-item">Projects</li>
                    <li class="breadcrumb-item active">Table View</li>
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
                <div class="card-header pb-0 card-no-border">
                    <a class="btn btn-primary" href="{{ route('projects.create') }}">Create New Project +</a>
                    <a class="btn btn-success" href="{{ route('projects.index') }}">Grid View</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display" id="basic-1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Project Code</th>
                                    <th>Name</th>
                                    <th>Client</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Priority</th>
                                    <th>Start Date</th>
                                    <th>Deadline</th>
                                    <th>Added Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $index => $project)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $project->project_code }}</td>
                                    <td>{{ $project->name }}</td>
                                    <td>{{ $project->client->name ?? '-' }}</td>
                                    <td>{{ $project->category->name ?? '-' }}</td>
                                    <td>
                                        @if ($project->status === 'Completed')
                                        <span class="badge badge-light-success">{{ $project->status }}</span>
                                        @elseif ($project->status === 'In Progress')
                                        <span class="badge badge-light-warning">{{ $project->status }}</span>
                                        @elseif ($project->status === 'On Hold')
                                        <span class="badge badge-light-secondary">{{ $project->status }}</span>
                                        @elseif ($project->status === 'Cancelled')
                                        <span class="badge badge-light-danger">{{ $project->status }}</span>
                                        @else
                                        <span class="badge badge-light-primary">{{ $project->status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $project->priority }}</td>
                                    <td>{{ $project->start_date }}</td>
                                    <td>{{ $project->deadline }}</td>
                                    <td>{{ $project->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <ul class="action">
                                            <li class="edit">
                                                <a href="{{ route('projects.show', $project->id) }}">
                                                    <i class="icon-eye" style="color:blue;"></i>
                                                </a>
                                            </li>
                                            <li class="edit">
                                                <a href="{{ route('projects.edit', $project->id) }}">
                                                    <i class="icon-pencil-alt"></i>
                                                </a>
                                            </li>
                                            <li class="delete">
                                                <form id="delete-form-{{ $project->id }}" action="{{ route('projects.destroy', $project->id) }}" method="POST" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="delete-btn" onclick="confirmDelete('delete-form-{{ $project->id }}');" style="border:none; background:none; cursor:pointer; padding:0;">
                                                        <i class="icon-trash" style="color:red;"></i>
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- table responsive -->
                </div>
            </div>
        </div>
    </div>
</div>

@endsection