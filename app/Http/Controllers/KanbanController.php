<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;

class KanbanController extends Controller
{
    public function index($project_id)
    {
        $project = Project::findOrFail($project_id);
        $tasks = Task::where('project_id', $project_id)->get();

        return view('kanban.index', compact('project', 'tasks'));
    }

    public function updateTaskStatus(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'status' => 'required|in:Pending,In Progress,Done',
        ]);

        $task = Task::findOrFail($request->task_id);
        $task->status = $request->status;
        $task->save();

        return response()->json(['success' => true]);
    }
}
