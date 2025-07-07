<?php
namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    // 📌 Get messages for a project where the user is assigned
    public function index($projectId)
    {
        // Get the project and ensure user is assigned
        $project = Project::whereHas('employees', function ($query) {
            $query->where('employee_id', Auth::id());
        })->findOrFail($projectId);

        // Fetch messages for this project
        $messages = Message::where('project_id', $projectId)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('messages.index', compact('project', 'messages'));
    }

    // 📌 Send a new message in a project chat
    public function store(Request $request, $projectId)
    {
        
        $request->validate([
            'message' => 'required|string',
            'project_id' => 'required|exists:projects,id' // ✅ Ensure project exists
        ]);
    
        Message::create([
            'sender_id' => auth()->id(),
            'project_id' => $request->project_id, // ✅ Correct way to get project_id
            'message' => $request->message,
        ]);
        return back()->with('success', 'Message sent successfully!');
    }
}
