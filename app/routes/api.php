<?php

use App\Controllers\EmployeeController;

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
