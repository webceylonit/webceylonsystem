<?php

use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientDocsController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\QAController;
use App\Http\Controllers\InternController;
use App\Http\Controllers\SeniorController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DesignerController;

use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProController;
use App\Http\Controllers\SprintController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\KanbanController;
use App\Http\Controllers\MessageController;

// Redirect logic
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('loginpage');
});

// Guest login routes
Route::middleware('guest')->group(function () {
    Route::get('/login-page', [LoginController::class, 'showLoginForm'])->name('loginpage');
    Route::post('/login-page', [LoginController::class, 'login']);
});

// Authenticated routes
Route::middleware(['auth:employee'])->group(function () {

    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

    Route::get('/unauthorized', function () {
        return view('errors.unauthorized');
    })->name('unauthorized');


    // Dashboards
    Route::get('/dashboard', fn() => view('AdminDashboard.home'))->name('dashboard');
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/manager', [ManagerController::class, 'index'])->name('manager.dashboard');
    Route::get('/qa', [QAController::class, 'index'])->name('qa.dashboard');
    Route::get('/intern', [InternController::class, 'index'])->name('intern.dashboard');
    Route::get('/senior', [SeniorController::class, 'index'])->name('senior.dashboard');
    Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.dashboard');
    Route::get('/designer', [DesignerController::class, 'index'])->name('designer.dashboard');

    // Role management
    Route::get('/roles', [RoleController::class, 'index'])->name('role.index');
    Route::get('/role/create', [RoleController::class, 'create'])->name('role.create');
    Route::post('/role/store', [RoleController::class, 'store'])->name('role.store');
    Route::get('/role/edit/{role}', [RoleController::class, 'edit'])->name('role.edit');
    Route::put('/role/update/{role}', [RoleController::class, 'update'])->name('role.update');
    Route::delete('/role/delete/{role}', [RoleController::class, 'destroy'])->name('role.destroy');

    // Profile
    Route::get('/editProfile', [EmployeeController::class, 'editProfile'])->name('profile.edit');
    Route::put('/updatePassword', [EmployeeController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::put('/updateMb2', [EmployeeController::class, 'updateMb2'])->name('profile.updateMb2');

    // Employee Management
    Route::get('/EmployeeIndex', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/EmployeeCreate', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/Employeestore', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/editEmployee{employee}', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroys');
    Route::get('/{employee}', [EmployeeController::class, 'show'])->name('employees.show');

    // Projects
    Route::prefix('projects')->group(function () {
        Route::get('ProjectIndex', [ProController::class, 'index'])->name('projects.index');
        Route::get('ProjectTable', [ProController::class, 'tableView'])->name('projects.tableView');
        Route::get('showProject/{project}', [ProController::class, 'show'])->name('projects.show');
        Route::get('projectcreate', [ProController::class, 'create'])->name('projects.create');
        Route::post('Projectstore', [ProController::class, 'store'])->name('projects.store');
        Route::get('editProject/{project}', [ProController::class, 'edit'])->name('projects.edit');
        Route::put('updateProject/{project}', [ProController::class, 'update'])->name('projects.update');
        Route::delete('deleteProject/{project}', [ProController::class, 'destroy'])->name('projects.destroy');
    });

    // Sprints
    Route::prefix('sprints')->group(function () {
        Route::get('SprintIndex', [SprintController::class, 'index'])->name('sprints.index');
        Route::get('showSprint/{sprint}', [SprintController::class, 'show'])->name('sprints.show');
        Route::get('Sprint-create', [SprintController::class, 'create'])->name('sprints.create');
        Route::post('Sprintstore', [SprintController::class, 'store'])->name('sprints.store');
        Route::get('editSprint/{sprint}', [SprintController::class, 'edit'])->name('sprints.edit');
        Route::put('updateSprint/{sprint}', [SprintController::class, 'update'])->name('sprints.update');
        Route::delete('deleteSprint/{sprint}', [SprintController::class, 'destroy'])->name('sprints.destroy');
    });

    // Tasks
    Route::prefix('tasks')->group(function () {
        Route::get('/sprint/{sprint}', [TaskController::class, 'index'])->name('tasks.index');
        Route::get('/create/{sprint}', [TaskController::class, 'create'])->name('tasks.create');
        Route::post('/store', [TaskController::class, 'store'])->name('tasks.store');
        Route::get('/edit/{task}', [TaskController::class, 'edit'])->name('tasks.edit');
        Route::put('/update/{task}', [TaskController::class, 'update'])->name('tasks.update');
        Route::delete('/delete/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    });

    // Task Updates
    Route::post('/tasks/{task}/update', [TaskController::class, 'addUpdate'])->name('tasks.addUpdate');
    Route::post('/tasks/update/{taskUpdate}/solve', [TaskController::class, 'solveUpdate'])->name('tasks.solveUpdate');

    // Kanban
    Route::prefix('kanban')->group(function () {
        Route::get('/{project_id}', [KanbanController::class, 'index'])->name('kanban.board');
        Route::post('/update-task-status', [KanbanController::class, 'updateTaskStatus'])->name('kanban.updateTaskStatus');
    });

    // Messaging
    Route::prefix('mesage')->group(function () {
        Route::get('/messages/project_list', [MessageController::class, 'projectList'])->name('messages.project_list');
        Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
        Route::post('/messages/send', [MessageController::class, 'sendMessage'])->name('messages.send');
        Route::get('/messages/fetch/{receiverId?}/{groupId?}', [MessageController::class, 'fetchMessages'])->name('messages.fetch');
    });

    Route::get('/projects/{project}/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/projects/{project}/messages', [MessageController::class, 'store'])->name('messages.store');

    Route::get('/documents/invoice', function () {
        return view('Documents.invoice');
    })->name('documents.invoice');

    Route::get('/clients/list', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('/clients/store', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/clients/edit/{client}', [ClientController::class, 'edit'])->name('clients.edit');
    Route::put('/clients/update/{client}', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('/clients/delete/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');
    Route::get('/clients/show/{client}', [ClientController::class, 'show'])->name('clients.show');

    Route::get('clientDocs', [ClientDocsController::class, 'index'])->name('clientDocs.index');
    Route::get('clientDocs/create', [ClientDocsController::class, 'create'])->name('clientDocs.create');
    Route::post('clientDocs/store', [ClientDocsController::class, 'store'])->name('clientDocs.store');
});

// Auth scaffolding routes (if using Laravel Breeze or similar)
require __DIR__ . '/auth.php';
