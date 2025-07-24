<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Employee;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
{
    $employeeCount = Employee::count();
    $projectCount = Project::count();
    $ongoingProjects = Project::where('status', 'In Progress')->count();
    $completedProjects = Project::where('status', 'Completed')->count();
    $clientCount = Client::count();
    $newProjects = Project::where('status', 'New')->count();

    // Monthly client growth
    $clientsByMonth = Client::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('count', 'month')
        ->toArray();

    // Monthly project growth
    $projectsByMonth = Project::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('count', 'month')
        ->toArray();

    // Fill missing months with 0
    $monthlyClients = [];
    $monthlyProjects = [];

    for ($i = 1; $i <= 12; $i++) {
        $monthlyClients[] = $clientsByMonth[$i] ?? 0;
        $monthlyProjects[] = $projectsByMonth[$i] ?? 0;
    }

    // Developer-specific data
    $user = Auth::user();

    $assignedProjectsCount = $user->projects()->count(); // assuming relation
    $devOngoing = $user->projects()->where('status', 'In Progress')->count();
    $devCompleted = $user->projects()->where('status', 'Completed')->count();

    // Tasks due today or soon
    $dueTodayCount = $user->tasks()->whereDate('due_date', Carbon::today())->count();
    $upcomingTasksCount = $user->tasks()->whereBetween('due_date', [
        Carbon::tomorrow(), Carbon::now()->addDays(7)
    ])->count();

    return view('AdminDashboard.home', compact(
        'employeeCount',
        'ongoingProjects',
        'completedProjects',
        'clientCount',
        'newProjects',
        'projectCount',
        'monthlyClients',
        'monthlyProjects',

        // developer values
        'assignedProjectsCount', 'devOngoing', 'devCompleted',
        'dueTodayCount', 'upcomingTasksCount'
    ));
}
}
