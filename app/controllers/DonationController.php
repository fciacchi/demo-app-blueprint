<?php

namespace App\Controllers;

use App\Models\Donation;
use App\Models\Mission;
use App\Models\Fundraiser;
use App\Models\Employee;
use App\Models\PaymentMethod;
use Exception;
use Leaf\Http\Response;

class DonationController extends Controller
{
    /**
     * Store a new donation for a mission.
     */
    public function store($fundraiserId, $missionId, $data)
    {
        $fundraiser = Fundraiser::find($fundraiserId);
        if (!$fundraiser) {
            return (new Response())->json(['error' => 'Fundraiser not found'], 404);
        }

        $mission = Mission::where('fundraiser_id', $fundraiserId)->find($missionId);
        if (!$mission) {
            return (new Response())->json(['error' => 'Mission not found'], 404);
        }

        if (!is_array($data)) {
            return (new Response())->json(['error' => 'Validation errors'], 406);
        }

        if (!isset($data['employee_id']) || !isset($data['payment_method_id']) || !isset($data['amount'])) {
            return (new Response())->json(['error' => 'Missing required fields'], 422);
        }

        $employee = Employee::find($data['employee_id']);
        if (!$employee) {
            return (new Response())->json(['error' => 'Employee not found'], 404);
        }

        $paymentMethod = PaymentMethod::where('employee_id', $data['employee_id'])->find($data['payment_method_id']);
        if (!$paymentMethod) {
            return (new Response())->json(['error' => 'Payment method not found'], 404);
        }

        try {
            unset($data['id'], $data['created_at'], $data['updated_at']);
            $data['fundraiser_id'] = $fundraiserId;
            $data['mission_id'] = $missionId;

            $donation = Donation::create($data);
            return (new Response())->json($donation, 201);
        } catch (Exception $exception) {
            return (new Response())->json(['exception' => $exception->getMessage()], 500);
        }
    }

    /**
     * Show a donation by ID for a specific mission.
     */
    public function show($fundraiserId, $missionId, $id): void
    {
        $donation = Donation::where('mission_id', $missionId)
                            ->find($id);

        if (!$donation) {
            (new Response())->json(['error' => 'Donation not found'], 404);
        } else {
            (new Response())->json($donation);
        }
    }

    /**
     * Get all donations for a specific mission, paginated.
     */
    public function index($fundraiserId, $missionId, $page, $expand = false)
    {
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $total = Donation::where('mission_id', $missionId)
                         ->count();
        $totalPages = ceil($total / $limit);

        if ($page > $totalPages) {
            return (new Response())->json(
                [
                    'donations' => [],
                    '_pages' => [
                        'current' => intval($page),
                        'total' => $totalPages
                    ]
                ],
                404
            );
        }

        $donations = Donation::where('mission_id', $missionId)
                             ->orderBy('created_at', 'desc')
                             ->skip($offset)
                             ->take($limit)
                             ->get();

        $allCollections = [];
        if ($expand) {
            $employeeCollection = [];
            $fundraiser = Fundraiser::find($fundraiserId);
            $mission = Mission::find($missionId);

            $creatorId = $fundraiser['employee_id'];
            $creator = Employee::find($creatorId);
            $employeeCollection[$creatorId] = $creator;

            foreach ($donations as $donation) {
                $employeeId = $donation['employee_id'];
                $employee = Employee::find($employeeId);
                $employeeCollection[$employeeId] = $employee;
            }


            $allCollections = [
                'employees' => $employeeCollection,
                'fundraisers' => [
                    $fundraiserId => $fundraiser,
                ],
                'missions' => [
                    $missionId => $mission,
                ]
            ];
        }//end if

        return (new Response())->json(
            [
                'donations' => $donations,
                '_collections' => $allCollections,
                '_pages' => [
                    'current' => intval($page),
                    'total' => $totalPages
                ]
            ]
        );
    }
}
