<?php

use App\Models\Mission;
use PHPUnit\Framework\TestCase;

class MissionTest extends TestCase
{
    private $mock;

    protected function setUp(): void
    {
        $this->mock = Mockery::mock('alias:App\Models\Mission');
    }

    public function testCreateMission()
    {
        $data = [
            'employee_id' => 1,
            'fundraiser_id' => 1,
            'name' => 'Test Mission',
            'website' => 'https://www.testmission.com',
            'description' => 'This is a Test Mission',
            'goal_amount' => 5000,
            'goal_currency' => 'USD',
            'goal_end_date' => '2025-12-31'
        ];

        $this->mock->shouldReceive('create')->once()->with($data)->andReturn((object) $data);

        $mission = Mission::create($data);

        $this->assertInstanceOf('stdClass', $mission);
        $this->assertEquals($data['name'], $mission->name);
        $this->assertEquals($data['website'], $mission->website);
    }

    public function testFindMission()
    {
        $data = [
            'id' => 1,
            'employee_id' => 1,
            'fundraiser_id' => 1,
            'name' => 'Test Mission',
            'website' => 'https://www.testmission.com',
            'description' => 'This is a Test Mission',
            'goal_amount' => 5000,
            'goal_currency' => 'USD',
            'goal_end_date' => '2025-12-31'
        ];

        $this->mock->shouldReceive('find')->once()->with(1)->andReturn((object) $data);

        $mission = Mission::find(1);

        $this->assertInstanceOf('stdClass', $mission);
        $this->assertEquals(1, $mission->id);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
