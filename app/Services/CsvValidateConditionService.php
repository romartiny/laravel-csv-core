<?php

namespace App\Services;

use App\Enums\CsvCondition as Condition;
use App\Services\Interfaces\CsvValidateConditionServiceInterface;
use Illuminate\Support\Carbon;

class CsvValidateConditionService implements CsvValidateConditionServiceInterface
{
    /**
     * The column name in the CSV file representing the product cost.
     */
    const costLineName = 'decProductCost';

    /**
     * The column name in the CSV file representing the product stock.
     */
    const stockLineName = 'intProductStock';

    /**
     * Checks the price condition for a CSV row.
     *
     * @param array $csvRow         The CSV row to be checked
     * @return bool                 Returns the price condition
     */
    private function checkPriceCondition(array $csvRow): bool
    {
        return isset($csvRow[self::costLineName])
            && intval($csvRow[self::costLineName]) >= Condition::MIN_PRICE
            && intval($csvRow[self::costLineName]) <= Condition::MAX_PRICE;
    }

    /**
     * Checks the stock condition for a CSV row.
     *
     * @param array $csvRow         The CSV row to be checked
     * @return bool                 Returns the stock condition
     */
    private function checkStockCondition(array $csvRow): bool
    {
        return isset($csvRow[self::stockLineName])
            && intval($csvRow[self::stockLineName]) >= Condition::MIN_STOCK;
    }

    /**
     * Check if the product is discontinued
     *
     * @param string $discontinued          Discontinued value from row
     * @return Carbon|null                  The Carbon instance of the current date
     */
    public function checkDiscontinuedCondition(string $discontinued): ?Carbon
    {
        return $discontinued === 'yes' ? now() : null;
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
