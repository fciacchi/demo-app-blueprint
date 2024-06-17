<?php

namespace App\Controllers;

use App\Models\PaymentMethod;
use App\Models\Employee;
use Exception;
use Leaf\Http\Response;

class PaymentMethodController extends Controller
{
    /**
     * Store a new payment method for an employee.
     */
    public function store($employeeId, $data)
    {
        $employee = Employee::find($employeeId);
        if (!$employee) {
            return (new Response())->json(['error' => 'Employee not found'], 404);
        }

        if (!is_array($data)) {
            return (new Response())->json(['error' => 'Validation errors'], 406);
        }

        if (!isset($data['type']) || !isset($data['cc_number'])) {
            return (new Response())->json(['error' => 'Missing required fields'], 422);
        }

        try {
            unset($data['id'], $data['created_at'], $data['updated_at']);
            $data['employee_id'] = $employeeId;

            $paymentMethod = PaymentMethod::create($data);
            return (new Response())->json($paymentMethod, 201);
        } catch (Exception $exception) {
            return (new Response())->json(['exception' => $exception->getMessage()], 500);
        }
    }

    /**
     * Show a payment method by ID for a specific employee.
     */
    public function show($employeeId, $id): void
    {
        $paymentMethod = PaymentMethod::where('employee_id', $employeeId)->find($id);

        if (!$paymentMethod) {
            (new Response())->json(['error' => 'Payment method not found'], 404);
        } else {
            (new Response())->json($paymentMethod);
        }
    }
}
