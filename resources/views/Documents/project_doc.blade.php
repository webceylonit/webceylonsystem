@extends('Documents.main')

@section('title', $doc->document_name)

@section('content')



<div class="content" style="font-family: 'Aptos', sans-serif; padding:60px 50px 100px 50px">

    {{-- Document Title --}}
    <h2 style="text-align:center; margin-bottom: 15px; font-size: 22px; color: #007793;">
        {{ $doc->document_name }}
    </h2>

    {{-- Project and Client Info --}}
    <div style="display: flex; justify-content: space-between;  padding: 15px; border-radius: 6px;">

        <!-- Client Info -->
        <div style="width: 48%;">
            <p><strong >Project Name:</strong> {{ $doc->project->name }} <br><br></p>
            <p>
                <strong>Client Name:</strong> {{ $doc->project->client->name ?? '-' }}<br>
                @if($doc->project->client->company)
                <strong>Company:</strong> {{ $doc->project->client->company }}<br>
                @endif
                <strong>Email:</strong> {{ $doc->project->client->email ?? '-' }}<br>
                <strong>Contact:</strong> {{ $doc->project->client->client_contact ?? '-' }}
            </p>
        </div>
    </div>

    {{-- Description --}}
    <div style="line-height: 1.6;">
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