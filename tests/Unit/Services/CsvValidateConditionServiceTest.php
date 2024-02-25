<?php

namespace Tests\Unit\Services;

use App\Services\CsvValidateConditionService;
use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\TestCase;

class CsvValidateConditionServiceTest extends TestCase
{
    /*
     * Set up the mock configurations for the test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        Config::shouldReceive('get')->with('csv.conditions.max_cost')->andReturn(100);
        Config::shouldReceive('get')->with('csv.conditions.min_cost')->andReturn(10);
        Config::shouldReceive('get')->with('csv.conditions.min_stock')->andReturn(5);
        Config::shouldReceive('get')->with('csv.conditions.discontinued')->andReturn('discontinued');
        Config::shouldReceive('get')->with('csv.fields.cost')->andReturn('cost');
        Config::shouldReceive('get')->with('csv.fields.stock')->andReturn('stock');
    }

    /*
     * Test the checkCsvConditions method of CsvValidateConditionService.
     */
    public function test_check_csv_conditions()
    {
        $service = new CsvValidateConditionService();

        $this->assertTrue($service->checkCsvConditions(['cost' => 50, 'stock' => 10]));

        $this->assertFalse($service->checkCsvConditions(['cost' => 5, 'stock' => 10]));

        $this->assertFalse($service->checkCsvConditions(['cost' => 50, 'stock' => 3]));

        $this->assertFalse($service->checkCsvConditions(['cost' => 5, 'stock' => 3]));
    }
}
