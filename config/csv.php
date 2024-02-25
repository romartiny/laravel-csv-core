<?php

return [
    'conditions' => [
        'min_cost' => env('CSV_CONDITION_MIN_COST', 5),
        'max_cost' => env('CSV_CONDITION_MAX_COST', 100),
        'min_stock' => env('CSV_CONDITION_MIN_STOCK', 10),
        'discontinued' => env('CSV_CONDITION_DISCONTINUED', 'yes')
    ],
    'fields' => [
        'cost' => env('CSV_FIELDS_COST', 'decProductCost'),
        'stock' => env('CSV_FIELDS_STOCK', 'intProductStock')
    ]
];
