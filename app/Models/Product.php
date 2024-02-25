<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method create(array $array)
 */
class Product extends Model
{
    use HasFactory;

    /**
     * The database table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, float, string>
     */
    protected $fillable = [
        'strProductDataCode',
        'strProductName',
        'strProductDesc',
        'intProductStock',
        'decProductCost',
        'dtmDiscontinued',
    ];

    /**
     * The array of attributes that should be cast to dates.
     *
     * @var array
     */
    protected array $dates = [
        'dtmAdded',
        'dtmDiscontinued',
        'stmTimestamp'
    ];

    /**
     *  Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
