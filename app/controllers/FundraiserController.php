<?php

namespace App\Controllers;

use App\Models\Fundraiser;
use App\Models\Employee;
use Exception;
use Leaf\Http\Response;

class FundraiserController extends Controller
{
    /**
     * Store a new fundraiser.
     */
    public function store($data)
    {
        if (!is_array($data)) {
            return (new Response())->json(['error' => 'Validation errors'], 406);
        }

        if (!isset($data['employee_id']) || !isset($data['name'])) {
            return (new Response())->json(['error' => 'Missing required fields'], 422);
        }

        $employee = Employee::find($data['employee_id']);
        if (!$employee) {
            return (new Response())->json(['error' => 'Employee not found'], 404);
        }

        try {
            unset($data['id'], $data['created_at'], $data['updated_at']);
            $fundraiser = Fundraiser::create($data);
            return (new Response())->json($fundraiser, 201);
        } catch (Exception $exception) {
            return (new Response())->json(['exception' => $exception->getMessage()], 500);
        }
    }

    /**
     * Show a fundraiser by ID.
     */
    public function show($id): void
    {
        $fundraiser = Fundraiser::find($id);

        if (!$fundraiser) {
            (new Response())->json(['error' => 'Fundraiser not found'], 404);
        } else {
            (new Response())->json($fundraiser);
        }
    }

    /**
     * Update a fundraiser by ID.
     */
    public function update($id, $data)
    {
        $fundraiser = Fundraiser::find($id);

        if (!$fundraiser) {
            return (new Response())->json(['error' => 'Fundraiser not found'], 404);
        }

        if (!is_array($data)) {
            return (new Response())->json(['error' => 'Validation errors'], 406);
        }

        if (!isset($data['employee_id']) || !isset($data['name'])) {
            return (new Response())->json(['error' => 'Missing required fields'], 422);
        }

        $employee = Employee::find($data['employee_id']);
        if (!$employee) {
            return (new Response())->json(['error' => 'Employee not found'], 404);
        }

        try {
            unset($data['id'], $data['created_at'], $data['updated_at']);
            $data['updated_at'] = date('Y-m-d H:i:s');

            $fundraiser->update($data);
            return (new Response())->noContent();
        } catch (Exception $exception) {
            return (new Response())->json(['exception' => $exception->getMessage()], 500);
        }
    }

    /**
     * Get all fundraisers, paginated.
     */
    public function index($page)
    {
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $total = Fundraiser::count();
        $totalPages = ceil($total / $limit);

        if ($page > $totalPages) {
            return (new Response())->json(
                [
                    'fundraisers' => [],
                    'pages' => [
                        'current' => $page,
                        'total' => $totalPages
                    ]
                ],
                404
            );
        }

        $fundraisers = Fundraiser::orderBy('created_at', 'desc')
            ->skip($offset)->take($limit)->get();

            return (new Response())->json(
                [
                'fundraisers' => $fundraisers,
                'pages' => [
                    'current' => $page,
                    'total' => $totalPages
                ]
                ]
            );
    }
}
