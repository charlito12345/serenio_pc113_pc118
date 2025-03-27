<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Exception; // Import the Exception class to catch errors

class StudentController extends Controller
{
    public function index(Request $request)
    {
        try {
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
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while retrieving students.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'address' => 'required|string',
                'age' => 'required|integer', 
                'email_address' => 'required|email|unique:students,email_address',
                'phone_number' => 'required|string',
                'emergency_contact' => 'required|string',
            ]);
        
            $student = Student::create($validatedData);
        
            return response()->json([
                'message' => 'Student created successfully',
                'student' => $student,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while creating the student.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $student = Student::find($id);

            if (!$student) {
                return response()->json(['message' => 'Student not found'], 404);
            }

            $validatedData = $request->validate([
                'first_name' => 'sometimes|string',
                'last_name' => 'sometimes|string',
                'email_address' => 'sometimes|email|unique:students,email_address,' . $id,
                'address' => 'sometimes|string',
                'age' => 'sometimes|integer',
                'phone_number' => 'sometimes|string',
                'emergency_contact' => 'sometimes|string',
            ]);

            $student->update($validatedData);

            return response()->json([
                'student' => $student,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while updating the student.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $student = Student::find($id);

            if (!$student) {
                return response()->json(['message' => 'Student not found'], 404);
            }

            $student->delete();

            return response()->json([
                'message' => 'Student deleted successfully',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while deleting the student.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
