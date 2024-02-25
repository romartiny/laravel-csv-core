<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\CsvProductRepositoryInterface as CsvProductRepositoryInterface;

class CsvProductRepository implements CsvProductRepositoryInterface
{
    /**
     * Constructor for the CsvProductRepository class.
     *
     * @param Product $_product         The Product instance
     */
    public function __construct(
      private readonly Product $_product
    ) {}

    /**
     * Creates a product row in the database based on the provided CSV row data.
     *
     * @param array $csvRow         The CSV row data
     * @return mixed                The result of the creation
     */
    public function createProductRow(array $csvRow): mixed
    {
        return $this->_product->create([
            'strProductDataCode' => $csvRow['strProductDataCode'],
            'strProductName' => $csvRow['strProductName'],
            'strProductDesc' => $csvRow['strProductDesc'],
            'intProductStock' => $csvRow['intProductStock'],
            'decProductCost' => $csvRow['decProductCost'],
            'dtmDiscontinued' => $csvRow['dtmDiscontinued'] === 'yes' ? now() : null,
        ]);
    }
}
