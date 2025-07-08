<?php

namespace App\Http\Controllers;

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
        $roles = Role::all(); // Fetch all roles for the dropdown
        return view('Employee.create', compact('roles')); // Pass roles to the view
    }

    public function show($id)
    {
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
            'employee_number' => 'required|string|max:20|unique:employees,employee_number',
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
        $roles = Role::all(); // Fetch all roles for the dropdown
        return view('Employee.edit', compact('employee', 'roles'));
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
            'employee_number' => 'nullable|string|max:20',
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
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }

    public function editProfile()
    {
        $employee = Employee::findOrFail(Auth::id());
        return view('Employee.profile', compact('employee'));
    }

    public function updateName(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = Auth::user();

        if ($user->name === $request->name) {
            return back()->with('success', 'Name is already up to date.');
        }

        $user->name = $request->name;
        $user->save();

        return back()->with('success', 'Name updated successfully!');
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
