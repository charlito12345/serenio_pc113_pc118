<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use App\Models\Employee;
use Illuminate\Http\Request;
use Exception; 
class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Employee::query();

            if ($request->has('search')) {
                $search = $request->input('search');
                $query->where('first_name', 'LIKE', "%{$search}%")
                      ->orWhere('last_name', 'LIKE', "%{$search}%")
                      ->orWhere('email_address', 'LIKE', "%{$search}%")
                      ->orWhere('address', 'LIKE', "%{$search}%")
                      ->orWhere('age', 'LIKE', "%{$search}%")
                      ->orWhere('phone_number', 'LIKE', "%{$search}%");
            }

            $employees = $query->get();

            return response()->json($employees);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while retrieving employees.',
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
                'email_address' => 'required|email|unique:employees,email_address',
                'phone_number' => 'required|string',
            ]);

            $employee = Employee::create($validatedData);

            return response()->json([
                'message' => 'Employee created successfully',
                'employee' => $employee,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation error occurred.',
                'message' => $e->getMessage(),
            ], 422); 
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while creating the employee.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $employee = Employee::find($id);

            if (!$employee) {
                return response()->json(['message' => 'Employee not found'], 404);
            }

            $validatedData = $request->validate([
                'first_name' => 'sometimes|string',
                'last_name' => 'sometimes|string',
                'email_address' => 'sometimes|email|unique:employees,email_address,' . $id,
                'address' => 'sometimes|string',
                'age' => 'sometimes|integer',
                'phone_number' => 'sometimes|string',
            ]);

            $employee->update($validatedData);

            return response()->json([
                'employee' => $employee,
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation error occurred.',
                'message' => $e->getMessage(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while updating the employee.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $employee = Employee::find($id);

            if (!$employee) {
                return response()->json(['message' => 'Employee not found'], 404);
            }

            $employee->delete();

            return response()->json([
                'message' => 'Employee deleted successfully',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while deleting the employee.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
