<?php

namespace Tests\Unit\Services;

use App\Services\CsvValidatorService;
use PHPUnit\Framework\TestCase;

class CsvValidatorServiceTest extends TestCase
{
    protected CsvValidatorService $csvValidator;

    /*
     * Set up the CsvValidatorService instance for testing.
     */
    protected function setUp(): void
    {
        $this->csvValidator = new CsvValidatorService();
    }

    /*
     * Test the csvValidateRow method with valid data.
     */
    public function test_csv_validate_row_with_valid_data(): void
    {
        $headers = ['header1', 'header2', 'header3'];
        $validRow = ['data1', 'data2', 'data3'];

        $this->assertTrue($this->csvValidator->csvValidateRow($headers, $validRow));
    }

    /*
     * Test the csvValidateRow method with an invalid number of columns.
     */
    public function test_csv_validate_row_with_invalid_number_of_columns(): void
    {
        $headers = ['header1', 'header2', 'header3'];
        $invalidRow = ['data1', 'data2'];

        $this->assertFalse($this->csvValidator->csvValidateRow($headers, $invalidRow));
    }

    /*
     * Test the csvValidateRow method with invalid characters.
     */
    public function test_csv_validate_row_with_invalid_characters(): void
    {
        $headers = ['header1', 'header2', 'header3'];
        $invalidRow = ['data1', 'data,2', 'data3'];

        $this->assertFalse($this->csvValidator->csvValidateRow($headers, $invalidRow));

        $invalidRow = ["data1", "data\n2", "data3"];

        $this->assertFalse($this->csvValidator->csvValidateRow($headers, $invalidRow));

        $invalidRow = ["data1", "data\r2", "data3"];

        $this->assertFalse($this->csvValidator->csvValidateRow($headers, $invalidRow));
    }
}
