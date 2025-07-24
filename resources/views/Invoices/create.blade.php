@extends('AdminDashboard.master')
@section('title', 'Select Invoice Type')
@section('content')
<div class="container pt-5">
    <div class="card p-4">
        <h4 class="mb-3">Select Invoice Type</h4>
        <form action="{{ route('invoices.createseparate') }}" method="GET">
            <input type="hidden" name="project_id" value="{{ $project->id }}">
            <div class="form-check mb-2">
                <input class="form-check-input" type="radio" name="type" value="commercial" id="commercial" required>
                <label class="form-check-label" for="commercial">Commercial Invoice</label>
            </div>
            <div class="form-check mb-4">
                <input class="form-check-input" type="radio" name="type" value="tax" id="tax">
                <label class="form-check-label" for="tax">Tax Invoice</label>
            </div>
            <button type="submit" class="btn btn-primary">Continue</button>
        </form>
    </div>
</div>
@endsection
