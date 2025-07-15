@extends('AdminDashboard.master')
@section('title', 'Add Document')
@section('content')

<div class="container-fluid">
    <div class="card">
        <form method="POST" action="{{ route('clientDocs.store') }}">
            @csrf
            <div class="card-header">
                <h4 class="card-title">Add Document</h4>
            </div>
            <div class="card-body row">

                <div class="col-md-6 mb-3">
                    <label>Client</label>
                    <select name="client_id" class="form-control" required>
                        <option value="">-- Select Client --</option>
                        @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Project Name (optional)</label>
                    <input type="text" name="project_name" class="form-control" placeholder="Enter project name (optional)">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Document Name *</label>
                    <input type="text" name="document_name" class="form-control" required>
                </div>

                <div class="col-md-12 mb-3">
                    <label>Description 01</label>
                    <textarea name="description_1" class="form-control" rows="2" placeholder="Document description 01"></textarea>
                </div>
                <div class="col-md-12 mb-3">
                    <label>Description 02</label>
                    <textarea name="description_2" class="form-control" rows="2" placeholder="Document description 02"></textarea>
                </div>


            </div>
            <div class="card-footer text-end">
                <button class="btn btn-primary" type="submit">Save and Print</button>
            </div>
        </form>
    </div>
</div>

@endsection