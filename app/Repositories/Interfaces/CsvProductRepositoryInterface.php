<?php

namespace App\Repositories\Interfaces;

interface CsvProductRepositoryInterface
{
    public function createProductRow(array $csvRow): mixed;
}
