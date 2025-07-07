<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Project;
use App\Models\Role;
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'password' => 'required|string|min:6|confirmed',
            'start_date' => 'required|date',
            'status' => 'required|string|in:Active,Inactive',
            'role_id' => 'required|exists:roles,id',
        ]);

        // Convert status to numeric representation
        $validated['status'] = $validated['status'] === 'Active' ? 1 : 0;

        // Hash the password
        $validated['password'] = Hash::make($validated['password']);

        // Create the employee
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
            'status' => 'required|string|in:Active,Inactive',
            'role_id' => 'required|exists:roles,id',
        ]);

        // Convert status to numeric representation
        $validated['status'] = $validated['status'] === 'Active' ? 1 : 0;

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']); // Hash the new password
        } else {
            unset($validated['password']); // Don't update password if not provided
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
}
