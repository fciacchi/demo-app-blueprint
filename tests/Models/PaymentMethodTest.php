<?php

use App\Models\PaymentMethod;
use PHPUnit\Framework\TestCase;

class PaymentMethodTest extends TestCase
{
    private $mock;

    protected function setUp(): void
    {
        $this->mock = Mockery::mock('alias:App\Models\PaymentMethod');
    }

    public function testCreatePaymentMethod()
    {
        $data = [
            'employee_id' => 1,
            'type' => 'credit_card',
            'cc_number' => '4111111111111111',
            'cc_ccv' => '123',
            'expiration_month' => '12',
            'expiration_year' => '2025'
        ];

        $this->mock->shouldReceive('create')->once()->with($data)->andReturn((object) $data);

        $paymentMethod = PaymentMethod::create($data);

        $this->assertInstanceOf('stdClass', $paymentMethod);
        $this->assertEquals($data['type'], $paymentMethod->type);
        $this->assertEquals($data['cc_number'], $paymentMethod->cc_number);
    }

    public function testFindPaymentMethod()
    {
        $data = [
            'id' => 1,
            'employee_id' => 1,
            'type' => 'credit_card',
            'cc_number' => '4111111111111111',
            'cc_ccv' => '123',
            'expiration_month' => '12',
            'expiration_year' => '2025'
        ];

        $this->mock->shouldReceive('find')->once()->with(1)->andReturn((object) $data);

        $paymentMethod = PaymentMethod::find(1);

        $this->assertInstanceOf('stdClass', $paymentMethod);
        $this->assertEquals(1, $paymentMethod->id);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
