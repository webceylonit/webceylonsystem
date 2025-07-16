@extends('Documents.main')

@section('title', $doc->document_name)

@section('content')
<div class="content">

    {{-- Document Title --}}
    <h2 style="text-align:center; margin-bottom: 20px;">
        {{ $doc->document_name }}
    </h2>

    {{-- Project Info --}}
    <p><strong>Project:</strong> {{ $doc->project->name }}</p>

    {{-- Client Info --}}
    <div style="margin-top: 10px; margin-bottom: 20px;">
        <strong>Isssued To:</strong><br>
         {{ $doc->project->client->name ?? '' }}<br>
         @if($doc->project->client->company)
         {{ $doc->project->client->company ?? '' }}<br>
         @endif
         {{ $doc->project->client->email ?? '' }}<br>
         {{ $doc->project->client->client_contact ?? '' }}
    </div>

    {{-- Description --}}
    <div>
        <!-- <strong>Description:</strong><br> -->
        {!! $doc->description !!}
    </div>

</div>
@endsection

@section('scripts')
<script>
    window.onafterprint = function() {
        window.location.href = "{{ route('projectDocs.index') }}";
    };
</script>
@endsection