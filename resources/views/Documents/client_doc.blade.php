@extends('Documents.main')

@section('title', $doc->document_name)

@section('content')
<div class="content">

    {{-- Document Title --}}
    <h2 style="text-align:center; margin-bottom: 20px;">
        {{ $doc->document_name }}
    </h2>

    {{-- Project Info --}}
    @if ($doc->project_name)
    <p><strong>Project:</strong> {{ $doc->project_name }}</p>
    @endif

    {{-- Client Info --}}
    <div style="margin-top: 10px; margin-bottom: 20px;">
        <strong>Isssued To:</strong><br>
        {{ $doc->client->name ?? '' }}<br>
        @if($doc->client->company)
        {{ $doc->client->company ?? '' }}<br>
        @endif
        {{ $doc->client->email ?? '' }}<br>
        {{ $doc->client->client_contact ?? '' }}
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
        window.location.href = "{{ route('clientDocs.index') }}";
    };
</script>
@endsection