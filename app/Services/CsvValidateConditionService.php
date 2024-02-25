<?php

namespace App\Services;

use App\Services\Interfaces\CsvValidateConditionServiceInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class CsvValidateConditionService implements CsvValidateConditionServiceInterface
{
    /*
     * Represents the maximum cost condition for products.
     */
    private int $maxCostCondition;

    /*
     * Represents the minimum cost condition for products.
     */
    private int $minCostCondition;

    /*
     * Represents the minimum stock condition for products.
     */
    private int $minStockCondition;

    /*
     * Represents the discontinued condition for products.
     */
    private string $discontinuedCondition;

    /*
     * The column name in the CSV file representing the product cost.
     */
    private string $costLineName;

    /*
     * The column name in the CSV file representing the product stock.
     */
    private string $stockLineName;

    /*
     * Constructor for the CsvValidateConditionService class.
     */
    public function __construct()
    {
        $this->maxCostCondition = Config::get('csv.conditions.max_cost');
        $this->minCostCondition = Config::get('csv.conditions.min_cost');
        $this->minStockCondition = Config::get('csv.conditions.min_stock');
        $this->discontinuedCondition = Config::get('csv.conditions.discontinued');
        $this->costLineName = Config::get('csv.fields.cost');
        $this->stockLineName = Config::get('csv.fields.stock');
    }

    /**
     * Checks the price condition for a CSV row.
     *
     * @param array $csvRow         The CSV row to be checked
     * @return bool                 Returns the price condition
     */
    private function checkPriceCondition(array $csvRow): bool
    {
        return isset($csvRow[$this->costLineName])
            && intval($csvRow[$this->costLineName]) >= $this->minCostCondition
            && intval($csvRow[$this->costLineName]) <= $this->maxCostCondition;
    }

    /**
     * Checks the stock condition for a CSV row.
     *
     * @param array $csvRow         The CSV row to be checked
     * @return bool                 Returns the stock condition
     */
    private function checkStockCondition(array $csvRow): bool
    {
        return isset($csvRow[$this->stockLineName])
            && intval($csvRow[$this->stockLineName]) >= $this->minStockCondition;
    }

    /**
     * Check if the product is discontinued
     *
     * @param string $discontinued          Discontinued value from row
     * @return Carbon|null                  The Carbon instance of the current date
     */
    public function checkDiscontinuedCondition(string $discontinued): ?Carbon
    {
        return $discontinued === $this->discontinuedCondition ? now() : null;
    }

    /**
     * Checks all CSV conditions for a given CSV row.
     *
     * @param array $csvRow         The CSV row to be checked
     * @return bool                 Returns true if all CSV conditions are met, otherwise false
     */
    public function checkCsvConditions(array $csvRow): bool
    {
        return $this->checkPriceCondition($csvRow) && $this->checkStockCondition($csvRow);
    }
}
