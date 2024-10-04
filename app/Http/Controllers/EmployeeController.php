<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $jsonData = file_get_contents(public_path('employees.json'));
        $employees = json_decode($jsonData, true);

        return view('employees.index', compact('employees'));
    }

    public function listEmp()
    {
        $jsonData = file_get_contents(public_path('employees.json'));
        $employees = json_decode($jsonData, true);

        return view('employees.listEmp', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'gender' => 'required|string',
            'maritalStatus' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
            'dob' => 'required|date',
            'nation' => 'required|string',
            'hireDate' => 'required|date',
            'department' => 'required|string',
        ]);

        $employee = Employee::create($request->all());

        $employees = Employee::all();
        $jsonData = json_encode($employees);
        file_put_contents(public_path('employees.json'), $jsonData);

        return redirect()->route('employees.listEmp')->with('success', 'Employee added successfully.');
    }
}