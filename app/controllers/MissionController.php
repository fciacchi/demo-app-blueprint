<?php

namespace App\Controllers;

use App\Models\Mission;
use App\Models\Fundraiser;
use App\Models\Employee;
use Exception;
use Leaf\Http\Response;

class MissionController extends Controller
{
    /**
     * Store a new mission for a fundraiser.
     */
    public function store($fundraiserId, $data)
    {
        $fundraiser = Fundraiser::find($fundraiserId);
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
            $data['fundraiser_id'] = $fundraiserId;

            $mission = Mission::create($data);
            return (new Response())->json($mission, 201);
        } catch (Exception $exception) {
            return (new Response())->json(['exception' => $exception->getMessage()], 500);
        }
    }

    /**
     * Show a mission by ID for a specific fundraiser.
     */
    public function show($fundraiserId, $id): void
    {
        $mission = Mission::where('fundraiser_id', $fundraiserId)->find($id);

        if (!$mission) {
            (new Response())->json(['error' => 'Mission not found'], 404);
        } else {
            (new Response())->json($mission);
        }
    }

    /**
     * Update a mission by ID for a specific fundraiser.
     */
    public function update($fundraiserId, $id, $data)
    {
        $mission = Mission::where('fundraiser_id', $fundraiserId)->find($id);

        if (!$mission) {
            return (new Response())->json(['error' => 'Mission not found'], 404);
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

            $mission->update($data);
            return (new Response())->noContent();
        } catch (Exception $exception) {
            return (new Response())->json(['exception' => $exception->getMessage()], 500);
        }
    }
}
