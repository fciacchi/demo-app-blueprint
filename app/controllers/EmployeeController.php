<?php

namespace App\Controllers;

use App\Models\Employee;
use Exception;
use Leaf\Http\Response;

class EmployeeController extends Controller
{
    /**
     * Store a new employee.
     */
    public function store($data)
    {
        if (!is_array($data)) {
            return (new Response())->json(['error' => 'Validation errors'], 406);
        }

        if (!isset($data['username']) || !isset($data['email'])) {
            return (new Response())->json(['error' => 'Missing required fields'], 422);
        }

        try {
            // Remove unmodifiable fields.
            unset($data['id'], $data['created_at'], $data['updated_at']);

            $employee = Employee::create($data);
            return (new Response())->json($employee, 201);
        } catch (Exception $exception) {
            return (new Response())->json(['exception' => $exception->getMessage()], 500);
        }
    }

    /**
     * Show an employee by ID.
     */
    public function show($id): void
    {
        $employee = Employee::find($id);

        if (!$employee) {
            (new Response())->json(['error' => 'Employee not found'], 404);
        } else {
            (new Response())->json($employee);
        }
    }

    /**
     * Update an employee by ID.
     */
    public function update($id, $data)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            Response()->json(['error' => 'Employee not found'], 404);
        } else {
            if (!is_array($data)) {
                return (new Response())->json(['error' => 'Validation errors'], 406);
            }

            if (!isset($data['username']) || !isset($data['email'])) {
                return (new Response())->json(['error' => 'Missing required fields'], 422);
            }

            try {
                // Remove unmodifiable fields.
                unset($data['id'], $data['created_at'], $data['updated_at']);

                // Update the `updated_at` field.
                $data['updated_at'] = date('Y-m-d H:i:s');

                $employee->update($data);
                return (new Response())->noContent();
            } catch (Exception $e) {
                return (new Response())->json(['exception' => $e->getMessage()], 500);
            }
        }//end if

        return null;
    }
}
