<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('first_name', 'LIKE', "%{$search}%")
                  ->orWhere('last_name', 'LIKE', "%{$search}%")
                  ->orWhere('email_address', 'LIKE', "%{$search}%")
                  ->orWhere('address', 'LIKE', "%{$search}%")
                  ->orWhere('age', 'LIKE', "%{$search}%")
                  ->orWhere('phone_number', 'LIKE', "%{$search}%");
        }

        $students = $query->get();

        return response()->json($students);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'address' => 'required|string',
            'age' => 'required|integer', 
            'email_address' => 'required|email|unique:employees,email_address',
            'phone_number' => 'required|string',
            'emergency_contact' => 'required|string',
        ]);
    
        $student = student::create($validatedData);
    
        return response()->json([
            'message' => 'student created successfully',
            'student' => $student,
        ], 201);
    }

    public function update(Request $request, $id)
{
    $student = student::find($id);

    if (!$student) {
        return response()->json(['message' => 'student not found'], 404);
    }

    $validatedData = $request->validate([
        'first_name' => 'sometimes|string',
        'last_name' => 'sometimes|string',
        'email_address' => 'sometimes|email|unique:employees,email_address,' . $id,
        'address' => 'sometimes|string',
        'age' => 'sometimes|integer',
        'phone_number' => 'sometimes|string',
        'emergency_contact' => 'sometimes|string',
    ]);

    $student->update($validatedData);

    return response()->json([
        'student' => $student,
    ], 200);
}

public function destroy($id)
{
    $student = student::find($id);

    if (!$student) {
        return response()->json(['message' => 'student not found'], 404);
    }

    $student->delete();

    return response()->json([
        'message' => 'student deleted']);
}

}