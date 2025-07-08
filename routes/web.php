<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProController;
use App\Http\Controllers\SprintController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\KanbanController;


use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\QAController;
use App\Http\Controllers\InternController;
use App\Http\Controllers\SeniorController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DesignerController;
use App\Http\Controllers\MessageController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard'); // Redirect logged-in users
    }
    return redirect()->route('loginpage'); // Redirect guests to login
});

Route::middleware('guest')->group(function () {
    Route::get('/login-page', [LoginController::class, 'showLoginForm'])->name('loginpage');
    Route::post('/login-page', [LoginController::class, 'login']);
});

// Protected Routes (Authenticated Users)
Route::middleware(['auth:employee'])->group(function () {
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

    Route::get('/roles', [RoleController::class, 'index'])->name('role.index');
    Route::get('/role/create', [RoleController::class, 'create'])->name('role.create');
    Route::post('/role/store', [RoleController::class, 'store'])->name('role.store');
    Route::get('/role/edit/{role}', [RoleController::class, 'edit'])->name('role.edit');
    Route::put('/role/update/{role}', [RoleController::class, 'update'])->name('role.update');
    Route::delete('role/delete/{role}', [RoleController::class, 'destroy'])->name('role.destroy');

    Route::get('/editProfile', [EmployeeController::class, 'editProfile'])->name('profile.edit');
    Route::put('/updatePassword', [EmployeeController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::put('/updateName', [EmployeeController::class, 'updateName'])->name('profile.updateName');
    // Role-Based Dashboards
    Route::get('/dashboard', function () {
        return view('AdminDashboard.home');
    })->name('dashboard');

    Route::middleware([RoleMiddleware::class . ':Admin'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    });

    Route::middleware([RoleMiddleware::class . ':Manager'])->group(function () {
        Route::get('/manager', [ManagerController::class, 'index'])->name('manager.dashboard');
    });

    Route::middleware([RoleMiddleware::class . ':QA'])->group(function () {
        Route::get('/qa', [QAController::class, 'index'])->name('qa.dashboard');
    });

    Route::middleware([RoleMiddleware::class . ':InternDeveloper'])->group(function () {
        Route::get('/intern', [InternController::class, 'index'])->name('intern.dashboard');
    });

    Route::middleware([RoleMiddleware::class . ':SeniorDeveloper'])->group(function () {
        Route::get('/senior', [SeniorController::class, 'index'])->name('senior.dashboard');
    });

    Route::middleware([RoleMiddleware::class . ':Employee'])->group(function () {
        Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.dashboard');
    });

    Route::middleware([RoleMiddleware::class . ':Designer'])->group(function () {
        Route::get('/designer', [DesignerController::class, 'index'])->name('designer.dashboard');
    });
});

// Employee Management Routes (Only Admin & Manager can access)
//Route::middleware([RoleMiddleware::class . ':Admin,Manager'])->group(function () {

Route::get('/EmployeeIndex', [EmployeeController::class, 'index'])->name('employees.index');
Route::get('/EmployeeCreate', [EmployeeController::class, 'create'])->name('employees.create');
Route::post('/Employeestore', [EmployeeController::class, 'store'])->name('employees.store');
Route::get('/editEmployee{employee}', [EmployeeController::class, 'edit'])->name('employees.edit');
Route::put('/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
Route::delete('/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroys');
Route::get('/{employee}', [EmployeeController::class, 'show'])->name('employees.show');
//});

// Project Management Routes (Only Admin & Manager can create/edit/delete projects)


Route::post('Projectstore', [ProController::class, 'store'])->name('projects.store');
Route::get('editProject/{project}', [ProController::class, 'edit'])->name('projects.edit');
Route::put('updateProject/{project}', [ProController::class, 'update'])->name('projects.update');
Route::delete('deleteProject/{project}', [ProController::class, 'destroy'])->name('projects.destroy');

// Anyone Assigned to Projects Can View Them
Route::prefix('projects')->group(function () {
    Route::get('ProjectIndex', [ProController::class, 'index'])->name('projects.index'); // View Projects
    Route::get('showProject/{project}', [ProController::class, 'show'])->name('projects.show'); // Show a project
    Route::get('projectcreate', [ProController::class, 'create'])->name('projects.create');
});


//  Sprint Routes (Admin & Managers Can Create, Edit, Delete; Everyone Can View)
Route::prefix('sprints')->group(function () {
    Route::middleware([RoleMiddleware::class . ':Admin,Manager'])->group(function () {
        Route::get('Sprint-create', [SprintController::class, 'create'])->name('sprints.create');
        Route::post('Sprintstore', [SprintController::class, 'store'])->name('sprints.store');
        Route::get('editSprint/{sprint}', [SprintController::class, 'edit'])->name('sprints.edit');
        Route::put('updateSprint/{sprint}', [SprintController::class, 'update'])->name('sprints.update');
        Route::delete('deleteSprint/{sprint}', [SprintController::class, 'destroy'])->name('sprints.destroy');
    });

    //  All Employees Can View Sprints
    Route::get('SprintIndex', [SprintController::class, 'index'])->name('sprints.index');
    Route::get('showSprint/{sprint}', [SprintController::class, 'show'])->name('sprints.show');
});

//  Task Routes (Only Admin & Managers Can Modify, Everyone Can View)
Route::prefix('tasks')->group(function () {
    Route::middleware([RoleMiddleware::class . ':Admin,Manager'])->group(function () {
        Route::get('/create/{sprint}', [TaskController::class, 'create'])->name('tasks.create');
        Route::post('/store', [TaskController::class, 'store'])->name('tasks.store');
        Route::get('/edit/{task}', [TaskController::class, 'edit'])->name('tasks.edit');
        Route::put('/update/{task}', [TaskController::class, 'update'])->name('tasks.update');
        Route::delete('/delete/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    });

    //  All Employees Can View Tasks
    Route::get('/sprint/{sprint}', [TaskController::class, 'index'])->name('tasks.index');
});


//kanban board
Route::prefix('kanban')->group(function () {
    Route::get('/{project_id}', [KanbanController::class, 'index'])->name('kanban.board'); // Show Kanban Board
    Route::post('/update-task-status', [KanbanController::class, 'updateTaskStatus'])->name('kanban.updateTaskStatus'); // Update Task Status via Drag & Drop
});



Route::prefix('mesage')->group(function () {
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages/send', [MessageController::class, 'sendMessage'])->name('messages.send');
    Route::get('/messages/fetch/{receiverId?}/{groupId?}', [MessageController::class, 'fetchMessages'])->name('messages.fetch');
});


Route::middleware(['auth:employee'])->group(function () {
    Route::get('/projects/{project}/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/projects/{project}/messages', [MessageController::class, 'store'])->name('messages.store');
});

Route::post('/tasks/{task}/update', [TaskController::class, 'addUpdate'])->middleware('auth')->name('tasks.addUpdate');
Route::post('/tasks/update/{taskUpdate}/solve', [TaskController::class, 'solveUpdate'])->middleware('auth')->name('tasks.solveUpdate');



require __DIR__ . '/auth.php';
