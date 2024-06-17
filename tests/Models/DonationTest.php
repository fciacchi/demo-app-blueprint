<?php

use App\Models\Donation;
use PHPUnit\Framework\TestCase;

class DonationTest extends TestCase
{
    private $mock;

    protected function setUp(): void
    {
        $this->mock = Mockery::mock('alias:App\Models\Donation');
    }

    public function testCreateDonation()
    {
        $data = [
            'employee_id' => 1,
            'mission_id' => 1,
            'payment_method_id' => 1,
            'amount' => 100,
            'currency' => 'USD'
        ];

        $this->mock->shouldReceive('create')->once()->with($data)->andReturn((object) $data);

        $donation = Donation::create($data);

        $this->assertInstanceOf('stdClass', $donation);
        $this->assertEquals($data['amount'], $donation->amount);
        $this->assertEquals($data['currency'], $donation->currency);
    }

    public function testFindDonation()
    {
        $data = [
            'id' => 1,
            'employee_id' => 1,
            'mission_id' => 1,
            'payment_method_id' => 1,
            'amount' => 100,
            'currency' => 'USD'
        ];

        $this->mock->shouldReceive('find')->once()->with(1)->andReturn((object) $data);

        $donation = Donation::find(1);

        $this->assertInstanceOf('stdClass', $donation);
        $this->assertEquals(1, $donation->id);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
