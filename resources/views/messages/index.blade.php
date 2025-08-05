@extends('AdminDashboard.master')

@section('title', 'Project Chat - ' . $project->name)

@section('content')
<div class="container-fluid">
    <div class="chat-header">
        <div class="chat-info">
            <div class="chat-group-details">
                <h4 class="mt-4">{{ $project->name }}</h4>
                <p>{{ count($project->employees) }} Members</p>
            </div>
        </div>
    </div>

    <!-- Chat Messages -->
    <div class="chat-box" id="chatBox">
        @foreach($messages as $message)
            <div class="chat-message {{ $message->sender_id == auth()->id() ? 'sent' : 'received' }}">
                <div class="message-content">
                    <strong>{{ $message->sender->name }}</strong><br>

                    @if($message->replyTo)
                        <div class="reply-block">
                            <small class="text-muted">↪ Reply to {{ $message->replyTo->sender->name }}:</small><br>
                            <em class="text-muted">{{ Str::limit($message->replyTo->message, 100) }}</em>
                            <hr class="my-1" />
                        </div>
                    @endif

                    <p>{!! nl2br(e($message->message)) !!}</p>
                    <small class="message-time">{{ $message->created_at->format('h:i A') }}</small>

                    <div class="d-flex justify-content-end gap-2 mt-2">
                        <!-- Reply always -->
                        <button type="button" onclick="setReply('{{ $message->id }}', '{{ $message->sender->name }}', `{{ strip_tags($message->message) }}`)" class="btn btn-sm btn-outline-primary">
                            <i class="fa fa-reply"></i> Reply
                        </button>

                        @if($message->sender_id == auth()->id())
                            <!-- Edit + Delete only for sender -->
                            <button type="button" onclick="editMessage('{{ $message->id }}', `{{ addslashes($message->message) }}`)" class="btn btn-sm btn-outline-warning">
                                <i class="fa fa-edit"></i> Edit
                            </button>
                            <form method="POST" action="{{ route('messages.destroy', $message->id) }}" class="d-inline" onsubmit="return confirm('Delete this message?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fa fa-trash"></i> Delete
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Chat Input -->
    @if(isset($project->id))
    <form method="POST" action="{{ route('messages.store', $project->id) }}" class="chat-input-form" id="chatForm">
        @csrf
        <input type="hidden" name="project_id" value="{{ $project->id }}">
        <input type="hidden" name="reply_to_id" id="replyToId">

        <!-- Reply preview -->
        <div id="replyPreview" class="reply-preview d-none">
            <div class="d-flex justify-content-between">
                <div>
                    <small>Replying to <span id="replySender"></span>:</small><br>
                    <em id="replyMessage" class="text-muted small"></em>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger ms-2" onclick="clearReply()">×</button>
            </div>
        </div>

        <!-- Input Field -->
        <div class="input-group mt-2">
            <textarea name="message" class="form-control chat-input" id="messageInput"
                      placeholder="Type your message..." required></textarea>
            <button type="submit" class="btn btn-primary chat-send-btn"><i class="fa fa-paper-plane"></i></button>
        </div>
    </form>
    @else
        <p class="text-danger text-center">Error: Project ID is missing.</p>
    @endif
</div>

<!-- Styles -->
<style>
.chat-header {
    display: flex;
    align-items: center;
    padding: 15px;
    background-color: #f8f9fa;
    border-bottom: 1px solid #ddd;
    margin-bottom: 10px;
}
.chat-box {
    max-height: calc(80vh - 220px);
    overflow-y: auto;
    padding: 15px;
    background-color: #f4f5f7;
    border-radius: 10px;
    margin-bottom: 60px;
    display: flex;
    flex-direction: column;
}
.chat-message {
    display: flex;
    flex-direction: column;
    max-width: 65%;
    padding: 10px 15px;
    border-radius: 10px;
    margin-bottom: 10px;
    position: relative;
    cursor: pointer;
}
.sent {
    align-self: flex-end;
    background-color: #1a237e;
    color: white;
    border-top-right-radius: 0;
}
.received {
    align-self: flex-start;
    background-color: #ffffff;
    color: #333;
    border-top-left-radius: 0;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
}
.message-content {
    font-size: 14px;
}
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
.chat-input-form {
    background: white;
    padding: 10px 0 0;
    border-top: 1px solid #ddd;
    border-radius: 0 0 10px 10px;
    margin-top: 20px;
}
.chat-input {
    border-radius: 25px;
    padding: 10px 15px;
    resize: none;
    min-height: 50px;
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
.reply-preview {
    background-color: #e9ecef;
    padding: 10px 12px;
    border-radius: 8px;
    margin-bottom: 10px;
}
.reply-block {
    background-color: #f1f1f1;
    border-left: 3px solid #aaa;
    padding-left: 10px;
    margin-bottom: 6px;
}
</style>

<!-- Scripts -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const chatBox = document.getElementById("chatBox");
        chatBox.scrollTop = chatBox.scrollHeight;

        const textarea = document.getElementById("messageInput");
        textarea.addEventListener("keydown", function (e) {
            if (e.key === "Enter" && !e.shiftKey) {
                e.preventDefault();
                document.getElementById("chatForm").submit();
            }
        });
    });

    function setReply(id, sender, message) {
        document.getElementById("replyToId").value = id;
        document.getElementById("replySender").textContent = sender;
        document.getElementById("replyMessage").textContent = message.substring(0, 100);
        document.getElementById("replyPreview").classList.remove("d-none");
    }

    function clearReply() {
        document.getElementById("replyToId").value = "";
        document.getElementById("replyPreview").classList.add("d-none");
    }

    function editMessage(id, currentText) {
        const newText = prompt("Edit your message:", currentText);
        if (newText !== null && newText.trim() !== '') {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/messages/${id}`;

            const token = document.createElement('input');
            token.name = '_token';
            token.value = '{{ csrf_token() }}';
            form.appendChild(token);

            const method = document.createElement('input');
            method.name = '_method';
            method.value = 'PUT';
            form.appendChild(method);

            const input = document.createElement('input');
            input.name = 'message';
            input.value = newText;
            form.appendChild(input);

            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
@endsection
