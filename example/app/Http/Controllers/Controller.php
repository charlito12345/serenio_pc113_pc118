<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function index()
    {
        return response()->json(Employee::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'f_name' => 'required|string',
            'l_name' => 'required|string',
            'm_name' => 'required|string',
            'email' => 'required|email|unique:employees,email',
            'position' => 'required|string',
        ]);

        $employee = Employee::create($request->all());

        return response()->json($employee, 201);
    }

    public function show($id)
    {
        $employee = Employee::findOrFail($id);

        return response()->json($employee);
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->update($request->all());

        return response()->json($employee);
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return response()->json(null, 204);
    }
}

