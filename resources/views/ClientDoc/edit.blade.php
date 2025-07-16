@extends('AdminDashboard.master')
@section('title', 'Edit Document')
@section('content')

<div class="container-fluid">
    <div class="card">
        <form method="POST" action="{{ route('clientDocs.update', $clientDoc->id) }}">
            @csrf
            @method('PUT')

            <div class="card-header">
                <h4 class="card-title">Edit Document</h4>
            </div>
            <div class="card-body row">

                <div class="col-md-6 mb-3">
                    <label>Client *</label>
                    <input type="hidden" name="client_id" value="{{ $clientDoc->client->id }}">
                    <input type="text" class="form-control" value="{{ $clientDoc->client->name }} ({{ $clientDoc->client->company_name ?? 'No company name' }})" readonly>
                    @error('client_id')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Project Name</label>
                    <input type="text" name="project_name" class="form-control" value="{{ old('project_name', $clientDoc->project_name) }}" placeholder="Add name for project">
                    @error('project_name')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Document Name *</label>
                    <input type="text" name="document_name" class="form-control" value="{{ old('document_name', $clientDoc->document_name) }}" required>
                    @error('document_name')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label>Description</label>
                    <div id="quill-editor" style="height: 500px;">{!! old('description', $clientDoc->description) !!}</div>
                    <input type="hidden" name="description" id="description">
                    @error('description')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

            </div>
            <div class="card-footer text-end">
                <button class="btn btn-primary" type="submit">Update</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<!-- Quill CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<!-- Quill JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
    $(document).ready(function () {
        var quill = new Quill('#quill-editor', {
            theme: 'snow',
            placeholder: 'Edit document description...',
            modules: {
                toolbar: [
                    [{ 'font': [] }],
                    [{ 'size': ['small', false, 'large', 'huge'] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'script': 'sub' }, { 'script': 'super' }],
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    [{ 'align': [] }],
                    ['blockquote', 'code-block'],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    [{ 'indent': '-1' }, { 'indent': '+1' }],
                    ['link', 'image', 'video'],
                    ['clean']
                ]
            }
        });

        // Set initial content
        quill.root.innerHTML = `{!! old('description', $clientDoc->description) !!}`;

        // Assign content to hidden input on form submission
        $("form").on("submit", function () {
            $("#description").val(quill.root.innerHTML.trim());
        });
    });
</script>
@endsection
