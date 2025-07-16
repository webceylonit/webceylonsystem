<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Employee;
use App\Models\Project;
use Illuminate\Http\Request;

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

    return view('AdminDashboard.home', compact(
        'employeeCount',
        'ongoingProjects',
        'completedProjects',
        'clientCount',
        'newProjects',
        'projectCount',
        'monthlyClients',
        'monthlyProjects'
    ));
}
}
