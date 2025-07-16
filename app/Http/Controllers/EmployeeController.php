<?php

namespace App\Http\Controllers;

use App\Services\PermissionService;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Project;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {

        if (!PermissionService::has('View Employees')) {
            return redirect()->route('unauthorized');
        }

        $employees = Employee::with('role')->get(); // Fetch all employees with their roles
        return view('Employee.index', compact('employees')); // Pass employees to the view
    }

    public function index1()
    {
        $projects = Project::all();
        return view('Projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create()
    {
        if (!PermissionService::has('Create Employees')) {
            return redirect()->route('unauthorized');
        }

        $internRole = Role::where('name', 'Intern Developer')->first();

        $employees = Employee::when($internRole, function ($query) use ($internRole) {
            $query->where('role_id', '!=', $internRole->id);
        })->get();
        $roles = Role::all();
        return view('Employee.create', compact('roles', 'employees'));
    }

    public function show($id)
    {
        if (!PermissionService::has('View Employees')) {
            return redirect()->route('unauthorized');
        }
        $employee = Employee::findOrFail($id); // Fetch the employee by ID or throw a 404 error
        return view('employees.show', compact('employee')); // Return the show view with the employee data
    }

    /**
     * Store a newly created employee in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'password' => 'required|string|min:6|confirmed',
            'start_date' => 'required|date',
            'status' => 'required|string|in:Available,Unavailable',
            'role_id' => 'required|exists:roles,id',
            'nic' => 'required|string|max:20|unique:employees,nic',
            'gender' => 'required|in:Male,Female,Other',
            'dob' => 'required|date|before:today',
            'mobile_number' => 'required|string|max:15',
            'mobile_number_2' => 'nullable|string|max:15',
            'employee_number' => 'required|string|max:20|unique:employees,employee_number',
            'rm_id' => 'required|exists:employees,id',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        // dd($validated);
        Employee::create($validated);

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }



    /**
     * Show the form for editing the specified employee.
     */
    public function edit(Employee $employee)
    {
        if (!PermissionService::has('Edit Employees')) {
            return redirect()->route('unauthorized');
        }
        $roles = Role::all();
        $internRole = Role::where('name', 'Intern Developer')->first();

        $rms = Employee::when($internRole, function ($query) use ($internRole) {
            $query->where('role_id', '!=', $internRole->id);
        })->where('id', '!=', $employee->id)->get();
        return view('Employee.edit', compact('employee', 'roles', 'rms'));
    }

    /**
     * Update the specified employee in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'password' => 'nullable|string|min:6|confirmed',
            'start_date' => 'required|date',
            'status' => 'required|in:Available,Unavailable',
            'role_id' => 'required|exists:roles,id',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female,Other',
            'nic' => 'nullable|string|max:20',
            'mobile_number' => 'nullable|string|max:15',
            'mobile_number_2' => 'nullable|string|max:15',
            'employee_number' => 'nullable|string|max:20',
            'rm_id' => 'required|exists:employees,id',
        ]);


        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $employee->update($validated);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }



    /**
     * Remove the specified employee from storage.
     */
    public function destroy(Employee $employee)
    {
        if (!PermissionService::has('Delete Employees')) {
            return redirect()->route('unauthorized');
        }
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }

    public function editProfile()
    {
        $employee = Employee::findOrFail(Auth::id());
        return view('Employee.profile', compact('employee'));
    }

    public function updateMb2(Request $request)
    {
        $request->validate([
            'mobile_number_2' => 'nullable|string|max:15',
        ]);

        $user = Auth::user();

       

        $user->mobile_number_2 = $request->mobile_number_2;
        $user->save();

        return back()->with('success', 'Mobile number updated successfully!');
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password updated successfully!');
    }
}
