@extends('AdminDashboard.master')

@section('title', 'Client Details')

@section('content')

<div class="container-fluid">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-6">
                <h4>Client Details</h4>
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
                    <li class="breadcrumb-item">Clients</li>
                    <li class="breadcrumb-item active">Details</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="container-fluid mt-3">
    <div class="card">
        <div class="card-header">
      <h4 class="card-title ">{{ $client->client_code }}</h4>
    </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-12 text-end">
                    @permission('Create Projects')
                    <a href="{{ route('projects.create', ['client_id' => $client->id]) }}" class="btn btn-success btn-sm">Create Project</a>
                    @endpermission
                    <a href="{{ route('clientDocs.create', ['client_id' => $client->id]) }}" class="btn btn-info btn-sm">Create Document</a>
                    @permission('Edit Clients')
                    <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    @endpermission
                    @permission('Delete Clients')
                    <form action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this client?')">Delete</button>
                    </form>
                    @endpermission
                </div>
            </div>

            <table class="table table-bordered">
                <!-- Section: Company -->
                <tr class="table-primary">
                    <th colspan="2">Company Details</th>
                </tr>
                <tr>
                    <th>Company Name</th>
                    <td>{{ $client->company ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Company Email</th>
                    <td>{{ $client->company_email ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Company Phone</th>
                    <td>{{ $client->phone ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Company Address</th>
                    <td>{{ $client->address ?? '-' }}</td>
                </tr>

                <!-- Section: Client -->
                <tr class="table-primary">
                    <th colspan="2">Client Details</th>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{ $client->name }}</td>
                </tr>
                <tr>
                    <th>Designation</th>
                    <td>{{ $client->designation }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $client->email }}</td>
                </tr>
                <tr>
                    <th>Contact</th>
                    <td>{{ $client->client_contact }}</td>
                </tr>

                <!-- Section: Other -->
                <tr class="table-primary">
                    <th colspan="2">Other Details</th>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $client->status }}</td>
                </tr>
                <tr>
                    <th>Notes</th>
                    <td>{{ $client->notes ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Added By</th>
                    <td>{{ $client->addedBy->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Added On</th>
                    <td>{{ $client->created_at->format('d-m-Y') }}</td>
                </tr>
            </table>

            @if($client->projects && $client->projects->count())
            <hr>
            <h5 class="mt-5 mb-2">Client's Projects</h5>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Project Code</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Added By</th>
                            <th>Start Date</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($client->projects as $project)
                        <tr>
                            <td>{{ $project->project_code }}</td>
                            <td>{{ $project->name }}</td>
                            <td>{{ $project->category->name ?? '-' }}</td>
                            <td>{{ $project->addedBy->name ?? '-' }}</td>
                            <td>{{ $project->start_date->format('d-m-Y') }}</td>
                            <td>{{ $project->deadline->format('d-m-Y') }}</td>
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
                            <td>
                                @permission('View Projects')
                                <a href="{{ route('projects.show', $project->id) }}" class="btn btn-primary btn-sm">View</a>
                                @endpermission
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

        </div>
    </div>
</div>

@endsection