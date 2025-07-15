@extends('AdminDashboard.master')

@section('title', 'Clients')

@section('content')

<div class="container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-6">
        <h4>Clients List</h4>
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
          <li class="breadcrumb-item active">Clients</li>
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
          <a href="{{ route('clients.create') }}" class="btn btn-primary">Add Client +</a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="display" id="basic-1">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Designation</th>
                  <th>Contact</th>
                  <th>Email</th>
                  <th>Company</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($clients as $index => $client)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $client->name }}</td>
                  <td>{{ $client->designation }}</td>
                  <td>{{ $client->client_contact }}</td>
                  <td>{{ $client->email }}</td>
                  <td>{{ $client->company ?? '-' }}</td>
                  <td>
                    @if ($client->status === 'Active')
                    <span class="badge badge-light-success">Active</span>
                    @else
                    <span class="badge badge-light-danger">Inactive</span>
                    @endif
                  </td>
                  
                  <td>
                    <ul class="action">
                      <li class="edit">
                        <a href="{{ route('clients.show', $client->id) }}" title="View Details">
                          <i class="icon-eye" style="color:blue;"></i>
                        </a>
                      </li>
                      <!-- <li class="edit">
                        <a href="{{ route('projects.create', ['client_id' => $client->id]) }}" title="Add Project for this Client">
                          <i class="icon-plus" style="color:blue;"></i>
                        </a>
                      </li> -->
                      <li class="edit">
                        <a href="{{ route('clients.edit', $client->id) }}">
                          <i class="icon-pencil-alt"></i>
                        </a>
                      </li>
                      <li class="delete">
                        <form id="delete-form-{{ $client->id }}" action="{{ route('clients.destroy', $client->id) }}" method="POST" class="delete-form">
                          @csrf
                          @method('DELETE')
                          <button type="button" class="delete-btn" onclick="confirmDelete('delete-form-{{ $client->id }}');" style="border:none; background:none; cursor:pointer; padding:0;">
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

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@if (session('new_client_id'))
<script>
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
      title: 'Client Created!',
      text: "Client '{{ session('new_client_name') }}' created successfully. Do you want to create a project for this client?",
      icon: 'success',
      showCancelButton: true,
      confirmButtonText: 'Yes, Create Project',
      cancelButtonText: 'No, Thanks'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "{{ route('projects.create', ['client_id' => session('new_client_id')]) }}";
      }
    });
  });
</script>
@endif

@endsection