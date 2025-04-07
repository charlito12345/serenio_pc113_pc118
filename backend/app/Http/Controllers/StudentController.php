<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse; 
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{
    public function list()
    {
        $students = student::all();

        return response()->json($students);
    }

    public function search(Request $request)
    {
        try {
            
            $query = Student::query();
    
            
            if ($request->has('search')) {
                $search = $request->input('search');
    
                
                $query->where('f_name', 'LIKE', "%{$search}%")
                      ->orWhere('m_name', 'LIKE', "%{$search}%")
                      ->orWhere('l_name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%");
            }
    
            
            $students = $query->get();
    
            
            return response()->json($students);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong with the search operation.',
                'message' => $e->getMessage(),
            ], 500);  
        }
    }
    

    public function studentsCreate(Request $request): JsonResponse
    {
        try {
            
            $validatedData = $request->validate([
                'f_name' => 'required|string',
                'm_name' => 'required|string',
                'l_name' => 'required|string',
                'email' => 'required|email|unique:students,email',
                'birth_date' => 'required|string',
            ]);
            
            
            $student = Student::create($validatedData);
            
            
            return response()->json([
                'message' => 'Student created successfully',
                'student' => $student,
            ], 201);
        } catch (\Exception $e) {
            
            return response()->json([
                'message' => 'Error creating student',
                'error' => $e->getMessage(),
            ], 500);  
        }
    }

    public function studentsUpdate(Request $request, $id): JsonResponse
    {
        try {
            $student = Student::find($id);

            if (!$student) {
                return response()->json([
                    'message' => 'Student not found',
                ], 404);
            }

            
            $validatedData = $request->validate([
                'f_name' => 'sometimes|string',
                'm_name' => 'sometimes|string',
                'l_name' => 'sometimes|string',
                'email' => 'sometimes|email|unique:students,email,' . $id,
                'birth_date' => 'sometimes|string',
            ]);

            
            $student->update($validatedData);

            return response()->json([
                'message' => 'Student updated successfully',
                'student' => $student,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error updating student',
                'error' => $e->getMessage(),
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
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error deleting student',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    

}