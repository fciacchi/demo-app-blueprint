<?php

use App\Controllers\EmployeeController;
use App\Controllers\PaymentMethodController;
use App\Controllers\FundraiserController;
use App\Controllers\MissionController;
use App\Controllers\DonationController;

app()->post('/api/employees/', static function (): void {
    $data = json_decode(file_get_contents('php://input'), true);
    $controller = new EmployeeController();
    $controller->store($data);
});

app()->get('/api/employees/{id}', static function ($id): void {
    $controller = new EmployeeController();
    $controller->show($id);
});

app()->put('/api/employees/{id}', static function ($id): void {
    $data = json_decode(file_get_contents('php://input'), true);
    $controller = new EmployeeController();
    $controller->update($id, $data);
});

app()->post('/api/employees/{id}/payment-method/', static function ($id): void {
    $data = json_decode(file_get_contents('php://input'), true);
    $controller = new PaymentMethodController();
    $controller->store($id, $data);
});

app()->get('/api/employees/{employee_id}/payment-method/{id}', static function ($employee_id, $id): void {
    $controller = new PaymentMethodController();
    $controller->show($employee_id, $id);
});

app()->post('/api/fundraisers/', static function (): void {
    $data = json_decode(file_get_contents('php://input'), true);
    $controller = new FundraiserController();
    $controller->store($data);
});

app()->get('/api/fundraisers/{id}', static function ($id): void {
    $controller = new FundraiserController();
    $controller->show($id);
});

app()->put('/api/fundraisers/{id}', static function ($id): void {
    $data = json_decode(file_get_contents('php://input'), true);
    $controller = new FundraiserController();
    $controller->update($id, $data);
});

app()->post('/api/fundraisers/{fundraiser_id}/missions/', static function ($fundraiser_id): void {
    $data = json_decode(file_get_contents('php://input'), true);
    $controller = new MissionController();
    $controller->store($fundraiser_id, $data);
});

app()->get('/api/fundraisers/{fundraiser_id}/missions/{id}', static function ($fundraiser_id, $id): void {
    $controller = new MissionController();
    $controller->show($fundraiser_id, $id);
});

app()->put('/api/fundraisers/{fundraiser_id}/missions/{id}', static function ($fundraiser_id, $id): void {
    $data = json_decode(file_get_contents('php://input'), true);
    $controller = new MissionController();
    $controller->update($fundraiser_id, $id, $data);
});

app()->post(
    '/api/fundraisers/{fundraiser_id}/missions/{mission_id}/donations/',
    static function ($fundraiser_id, $mission_id): void {
        $data = json_decode(file_get_contents('php://input'), true);
        $controller = new DonationController();
        $controller->store($fundraiser_id, $mission_id, $data);
    }
);

app()->get(
    '/api/fundraisers/{fundraiser_id}/missions/{mission_id}/donations/{id}',
    static function ($fundraiser_id, $mission_id, $id): void {
        $controller = new DonationController();
        $controller->show($fundraiser_id, $mission_id, $id);
    }
);
