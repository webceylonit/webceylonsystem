@extends('AdminDashboard.master')

@section('title', 'Project Chat - ' . $project->name)

@section('content')
<div class="container-fluid">
    <div class="chat-header">
        <div class="chat-info">
            <div class="chat-group">
                <div class="chat-group-details">
                    <h4 class="mt-4">{{ $project->name }}</h4>
                    <p>{{ count($project->employees) }} Members</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Scrollable Chat Box -->
    <div class="chat-box" id="chatBox">
        @foreach($messages as $message)
            <div class="chat-message {{ $message->sender_id == auth()->id() ? 'sent' : 'received' }}">
                <div class="message-content">
                    <strong>{{ $message->sender->name }}</strong></br>
                    <p>{{ $message->message }}</p>
                    <small class="message-time">{{ $message->created_at->format('h:i A') }}</small>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Fixed Input Field at Bottom -->
    @if(isset($project) && $project->id)
    <form method="POST" action="{{ route('messages.store', $project->id) }}" class="chat-input-form">
        @csrf
        <input type="hidden" name="project_id" value="{{ $project->id }}">
        <div class="input-group">
            <input type="text" name="message" class="form-control chat-input" placeholder="Type your message..." required>
            <button type="submit" class="btn btn-primary chat-send-btn"><i class="fa fa-paper-plane"></i></button>
        </div>
    </form>
    @else
        <p class="text-danger text-center">Error: Project ID is missing.</p>
    @endif
</div>

<style>
/* Chat Header */
.chat-header {
    display: flex;
    align-items: center;
    padding: 15px;
    background-color: #f8f9fa;
    border-bottom: 1px solid #ddd;
    margin-bottom: 10px;
}

/* Chat Box - Scrollable */
.chat-box {
    max-height: calc(100vh - 180px); /* Adjusts height dynamically */
    overflow-y: auto;
    padding: 15px;
    background-color: #f4f5f7;
    border-radius: 10px;
    margin-bottom: 60px; /* Space for the fixed input field */
    display: flex;
    flex-direction: column;
}

/* Chat Messages */
.chat-message {
    display: flex;
    flex-direction: column;
    max-width: 60%;
    padding: 10px 15px;
    border-radius: 10px;
    margin-bottom: 10px;
    position: relative;
}

/* Sent Messages (Right Side - Purple) */
.sent {
    align-self: flex-end;
    background-color: #6c5ce7;
    color: white;
    text-align: left;
    border-top-right-radius: 0;
}

/* Received Messages (Left Side - Grey) */
.received {
    align-self: flex-start;
    background-color: #ffffff;
    color: #333;
    text-align: left;
    border-top-left-radius: 0;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
}

/* Message Content */
.message-content {
    font-size: 14px;
}

/* Timestamp */
.message-time {
    font-size: 12px;
    display: block;
    margin-top: 5px;
    text-align: right;
    color: rgba(255, 255, 255, 0.8);
}

.received .message-time {
    color: rgba(0, 0, 0, 0.6);
}

/* Fixed Chat Input Field */
.chat-input-form {
    position: fixed;
    bottom: 8%;
    left: 30%;
    right: 0;
    width: 52%;
    background: white;
    padding: 10px;
    border-top: 1px solid #ddd;
    border-radius: 25px;
}

.chat-input {
    border-radius: 25px;
    padding: 10px 15px;
    flex: 1;
    border: 1px solid #ddd;
}

.chat-send-btn {
    border-radius: 50%;
    width: 40px;
    height: 50px;
    background-color: #6c5ce7;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
}

.chat-send-btn i {
    font-size: 18px;
}
</style>

<!-- Auto-scroll to bottom when new messages appear -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var chatBox = document.getElementById("chatBox");
        chatBox.scrollTop = chatBox.scrollHeight;
    });
</script>

@endsection
