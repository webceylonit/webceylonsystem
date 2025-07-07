<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard'); // Redirect if already logged in
        }
        return view('mainpages.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('employee')->attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            // Get the authenticated employee
            $employee = Auth::guard('employee')->user();

            // Store employee name in session
            session(['employee_name' => $employee->name]);

            // Redirect to the correct dashboard based on role
            return $this->redirectToDashboard($employee);
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    private function redirectToDashboard($employee)
    {
        switch ($employee->role->name) {
            case 'Admin':
                return redirect()->route('admin.dashboard');
            case 'Manager':
                return redirect()->route('manager.dashboard');
            case 'QA':
                return redirect()->route('qa.dashboard');
            case 'InternDeveloper':
                return redirect()->route('intern.dashboard');
            case 'SeniorDeveloper':
                return redirect()->route('senior.dashboard');
            case 'Employee':
                return redirect()->route('employee.dashboard');
            case 'Designer':
                return redirect()->route('designer.dashboard');
            default:
                return redirect()->route('dashboard'); // Default dashboard
        }
    }
}
