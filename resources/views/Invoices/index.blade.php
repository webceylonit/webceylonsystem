@extends('AdminDashboard.master')

@section('title', 'Invoices')

@section('content')

<div class="container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-6">
        <h4>Invoices</h4>
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
          <li class="breadcrumb-item active">Invoices</li>
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
                  <th>Invoice No.</th>
                  <th>Project</th>
                  <th>Client</th>
                  <th>Total Amount</th>
                  <th>Created By</th>
                  <th>Created Date</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($invoices as $invoice)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $invoice->invoice_number }} </td>
                  <td>{{ $invoice->project->name }} ({{ $invoice->project->project_code }})</td>
                  <td>{{ $invoice->project->client->name }} </td>
                  <td>{{ $invoice->total_amount }} </td>
                  <td>{{ $invoice->addedBy->name }} </td>
                  <td>{{ $invoice->created_at->format('d-m-Y') }}</td>

                  <td>
                    <ul class="action">
                      @permission('View Invoices')
                      <li class="edit">
                        <a href="{{ route('invoices.print', $invoice->id) }}">
                          <i class="icon-printer" style="color: blue;"></i>
                        </a>
                      </li>
                      @endpermission
                      @permission('Edit Invoices')
                      <!-- <li class="edit">
                        <a href="{{ route('invoices.edit', $invoice->id) }}">
                          <i class="icon-pencil-alt"></i>
                        </a>
                      </li> -->
                      @endpermission
                      @permission('Delete Invoices')
                      <li class="delete">
                        <form id="delete-form-{{ $invoice->id }}" action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" class="delete-form">
                          @csrf
                          @method('DELETE')
                          <button type="button" class="delete-btn" onclick="confirmDelete('delete-form-{{ $invoice->id }}');" style="border:none; background:none; cursor:pointer; padding:0;">
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
@if (session('new_invoice_id'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            title: 'Invoice Created!',
            text: "Invoice {{ session('new_invoice_number') }} created successfully. Do you want to print it now?",
            icon: 'success',
            showCancelButton: true,
            confirmButtonText: 'Yes, Print',
            cancelButtonText: 'No, Thanks'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('invoices.print', session('new_invoice_id')) }}";
            }
        });
    });
</script>
@endif


@endsection