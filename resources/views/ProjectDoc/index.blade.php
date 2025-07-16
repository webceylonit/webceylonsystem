@extends('AdminDashboard.master')

@section('title', 'Project Documents')

@section('content')

<div class="container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-6">
        <h4>Project Documents</h4>
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
          <li class="breadcrumb-item">Documents</li>
          <li class="breadcrumb-item active">Project</li>
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
          
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="display" id="basic-1">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Project</th>
                  <th>Document Name</th>
                  <th>Created By</th>
                  <th>Created Date</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($projectDocs as $pd)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $pd->project->name }} ({{ $pd->project->project_code }})</td>
                  <td>{{ $pd->document_name }} </td>
                  <td>{{ $pd->addedBy->name }} </td>
                  <td>{{ $pd->created_at->format('d-m-Y') }}</td>
                  
                  <td>
                    <ul class="action">
                        @permission('View Documents')
                      <li class="edit">
                        <a href="{{ route('projectDocs.print', $pd->id) }}">
                          <i class="icon-printer" style="color: blue;"></i>
                        </a>
                      </li>
                      @endpermission
                      @permission('Edit Documents')
                      <li class="edit">
                        <a href="{{ route('projectDocs.edit', $pd->id) }}">
                          <i class="icon-pencil-alt"></i>
                        </a>
                      </li>
                      @endpermission
                      @permission('Delete Documents')
                      <li class="delete">
                        <form id="delete-form-{{ $pd->id }}" action="{{ route('projectDocs.destroy', $pd->id) }}" method="POST" class="delete-form">
                          @csrf
                          @method('DELETE')
                          <button type="button" class="delete-btn" onclick="confirmDelete('delete-form-{{ $pd->id }}');" style="border:none; background:none; cursor:pointer; padding:0;">
                            <i class="icon-trash" style="color:red;"></i>
                          </button>
                        </form>
                      </li>
                      @endpermission
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

@endsection

@section('scripts')
@if (session('new_doc_id'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            title: 'Document Created!',
            text: "Document '{{ session('new_doc_name') }}' created successfully. Do you want to print it?",
            icon: 'success',
            showCancelButton: true,
            confirmButtonText: 'Yes, Print Now',
            cancelButtonText: 'No, Thanks'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('projectDocs.print', session('new_doc_id')) }}";
            }
        });
    });
</script>
@endif

@endsection