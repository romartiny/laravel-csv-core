<?php

namespace Tests\Unit\Iterators;

use App\Iterators\CsvIterator;
use PHPUnit\Framework\TestCase;

class CsvIteratorTest extends TestCase
{
    protected string $csvPath;
    protected array $productFillable;

    /*
     * Set CSV path and product fillable data
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->csvPath = __DIR__ . '/../../Files/test.csv';
        $this->productFillable = ['id', 'name', 'price'];
    }

    /*
     * Test CSV Iterator.
     */
    public function test_csv_iterator(): void
    {
        $iterator = new CsvIterator($this->csvPath, $this->productFillable);

        $firstRow = $iterator->rewind();

        $this->assertEquals(['Product Code', 'Product Name', 'Product Description', 'Stock', 'Cost in GBP', 'Discontinued'], $firstRow);

        $key = $iterator->key();
        $this->assertEquals(0, $key);

        $iterator->next();
        $nextRow = $iterator->current();

        $this->assertEquals(['id' => 'P0001', 'name' => 'TV', 'price' => '32” Tv'], $nextRow);

        $this->assertTrue($iterator->valid());

        while ($iterator->valid()) {
            $iterator->next();
        }

        $this->assertFalse($iterator->valid());
    }

    /*
     * Test with an invalid CSV path.
     */
    public function test_invalid_csv_path(): void
    {
        $invalidCsvPath = 'nonexistent.csv';
        $this->expectException(\TypeError::class);
        new CsvIterator($invalidCsvPath, $this->productFillable);
    }
}
