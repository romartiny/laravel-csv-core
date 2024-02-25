<?php

return [

    /*
    |--------------------------------------------------------------------------
    | CSV Conditions
    |--------------------------------------------------------------------------
    |
    | These values represent conditions used in CSV processing.
    | Adjust these values as needed for your application.
    |
    */

    'conditions' => [

        // Minimum cost condition for products
        'min_cost' => env('CSV_CONDITION_MIN_COST', 5),

        // Maximum cost condition for products
        'max_cost' => env('CSV_CONDITION_MAX_COST', 100),

        // Minimum stock condition for products
        'min_stock' => env('CSV_CONDITION_MIN_STOCK', 10),

        // Discontinued condition for products
        'discontinued' => env('CSV_CONDITION_DISCONTINUED', 'yes')
    ],

    /*
     |--------------------------------------------------------------------------
     | CSV Fields
     |--------------------------------------------------------------------------
     |
     | These values represent column names in the CSV file.
     | Adjust these values as needed for your application.
     |
     */

    'fields' => [

        // Column name in the CSV file representing the product cost
        'cost' => env('CSV_FIELDS_COST', 'decProductCost'),

        // Column name in the CSV file representing the product stock
        'stock' => env('CSV_FIELDS_STOCK', 'intProductStock')
    ]
];
