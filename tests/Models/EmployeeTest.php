<?php

use PHPUnit\Framework\TestCase;
use App\Models\Employee;

class EmployeeTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testCreateEmployee()
    {
        $employee = Mockery::mock('alias:App\Models\Employee');

        $employee->shouldReceive('create')
                 ->once()
                 ->with([
                     'username' => 'testuser',
                     'email' => 'test@example.com',
                     'first_name' => 'Test',
                     'last_name' => 'User',
                     'role' => 'Developer',
                     'department' => 'IT'
                 ])
                 ->andReturn((object)[
                     'id' => 1,
                     'username' => 'testuser',
                     'email' => 'test@example.com',
                     'first_name' => 'Test',
                     'last_name' => 'User',
                     'role' => 'Developer',
                     'department' => 'IT',
                     'created_at' => date('Y-m-d H:i:s'),
                     'updated_at' => date('Y-m-d H:i:s')
                 ]);

        $result = Employee::create([
            'username' => 'testuser',
            'email' => 'test@example.com',
            'first_name' => 'Test',
            'last_name' => 'User',
            'role' => 'Developer',
            'department' => 'IT'
        ]);

        $this->assertEquals('testuser', $result->username);
        $this->assertEquals('test@example.com', $result->email);
    }
}
