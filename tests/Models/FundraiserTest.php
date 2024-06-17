<?php

use App\Models\Fundraiser;
use PHPUnit\Framework\TestCase;

class FundraiserTest extends TestCase
{
    private $mock;

    protected function setUp(): void
    {
        $this->mock = Mockery::mock('alias:App\Models\Fundraiser');
    }

    public function testCreateFundraiser()
    {
        $data = [
            'employee_id' => 1,
            'name' => 'Test Fundraiser',
            'website' => 'https://www.testwebsite.com',
            'description' => 'This is a Test Fundraiser',
            'goal_amount' => 3000,
            'goal_currency' => 'EUR',
            'goal_end_date' => '2024-12-31'
        ];

        $this->mock->shouldReceive('create')->once()->with($data)->andReturn((object) $data);

        $fundraiser = Fundraiser::create($data);

        $this->assertInstanceOf('stdClass', $fundraiser);
        $this->assertEquals($data['name'], $fundraiser->name);
        $this->assertEquals($data['website'], $fundraiser->website);
    }

    public function testFindFundraiser()
    {
        $data = [
            'id' => 1,
            'employee_id' => 1,
            'name' => 'Test Fundraiser',
            'website' => 'https://www.testwebsite.com',
            'description' => 'This is a Test Fundraiser',
            'goal_amount' => 3000,
            'goal_currency' => 'EUR',
            'goal_end_date' => '2024-12-31'
        ];

        $this->mock->shouldReceive('find')->once()->with(1)->andReturn((object) $data);

        $fundraiser = Fundraiser::find(1);

        $this->assertInstanceOf('stdClass', $fundraiser);
        $this->assertEquals(1, $fundraiser->id);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
