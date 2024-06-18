<?php

use App\Controllers\EmployeeController;
use App\Controllers\PaymentMethodController;
use App\Controllers\FundraiserController;
use App\Controllers\MissionController;
use App\Controllers\DonationController;

app()->get(
    '/api/employees/{employee_id}/payment-method/{payment_method_id}',
    static function ($employee_id, $payment_method_id): void {
        $controller = new PaymentMethodController();
        $controller->show($employee_id, $payment_method_id);
    }
);

app()->post(
    '/api/employees/{employee_id}/payment-method/',
    static function ($employee_id): void {
        $data = json_decode(file_get_contents('php://input'), true);
        $controller = new PaymentMethodController();
        $controller->store($employee_id, $data);
    }
);

app()->get(
    '/api/employees/{employee_id}',
    static function ($employee_id): void {
        $controller = new EmployeeController();
        $controller->show($employee_id);
    }
);

app()->put(
    '/api/employees/{employee_id}',
    static function ($employee_id): void {
        $data = json_decode(file_get_contents('php://input'), true);
        $controller = new EmployeeController();
        $controller->update($employee_id, $data);
    }
);

app()->post('/api/employees/', static function (): void {
    $data = json_decode(file_get_contents('php://input'), true);
    $controller = new EmployeeController();
    $controller->store($data);
});

app()->get(
    '/api/fundraisers/{fundraiser_id}/missions/{mission_id}/donations/{donation_id}',
    static function ($fundraiser_id, $mission_id, $donation_id): void {
        $controller = new DonationController();
        $controller->show($fundraiser_id, $mission_id, $donation_id);
    }
);

app()->get(
    '/api/fundraisers/{fundraiser_id}/missions/{mission_id}/donations/',
    static function ($fundraiser_id, $mission_id): void {
        $expand = $_GET['expand'] ?? false;
        $page = $_GET['page'] ?? 1;
        $controller = new DonationController();
        $controller->index($fundraiser_id, $mission_id, $page, $expand);
    }
);

app()->post(
    '/api/fundraisers/{fundraiser_id}/missions/{mission_id}/donations/',
    static function ($fundraiser_id, $mission_id): void {
        $data = json_decode(file_get_contents('php://input'), true);
        $controller = new DonationController();
        $controller->store($fundraiser_id, $mission_id, $data);
    }
);

app()->get(
    '/api/fundraisers/{fundraiser_id}/missions/{mission_id}',
    static function ($fundraiser_id, $mission_id): void {
        $controller = new MissionController();
        $controller->show($fundraiser_id, $mission_id);
    }
);

app()->put(
    '/api/fundraisers/{fundraiser_id}/missions/{mission_id}',
    static function ($fundraiser_id, $mission_id): void {
        $data = json_decode(file_get_contents('php://input'), true);
        $controller = new MissionController();
        $controller->update($fundraiser_id, $mission_id, $data);
    }
);

app()->get(
    '/api/fundraisers/{fundraiser_id}/missions/',
    static function ($fundraiser_id): void {
        $expand = $_GET['expand'] ?? false;
        $page = $_GET['page'] ?? 1;
        $controller = new MissionController();
        $controller->index($fundraiser_id, $page, $expand);
    }
);

app()->post(
    '/api/fundraisers/{fundraiser_id}/missions/',
    static function ($fundraiser_id): void {
        $data = json_decode(file_get_contents('php://input'), true);
        $controller = new MissionController();
        $controller->store($fundraiser_id, $data);
    }
);

app()->get('/api/fundraisers/{id}', static function ($id): void {
    $controller = new FundraiserController();
    $controller->show($id);
});

app()->put(
    '/api/fundraisers/{fundraiser_id}',
    static function ($fundraiser_id): void {
        $data = json_decode(file_get_contents('php://input'), true);
        $controller = new FundraiserController();
        $controller->update($fundraiser_id, $data);
    }
);

app()->get('/api/fundraisers/', static function (): void {
    $expand = $_GET['expand'] ?? false;
    $page = $_GET['page'] ?? 1;
    $controller = new FundraiserController();
    $controller->index($page, $expand);
});

app()->post('/api/fundraisers/', static function (): void {
    $data = json_decode(file_get_contents('php://input'), true);
    $controller = new FundraiserController();
    $controller->store($data);
});
