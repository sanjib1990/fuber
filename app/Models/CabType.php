<?php

namespace App\Models;

use App\Contracts\CabTypeContract;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CabType
 *
 * @package App\Models
 */
class CabType extends Model implements CabTypeContract
{
    /**
     * To avoid Mass assignment.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'price_per_km',
        'price_per_minute'
    ];

    /**
     * A cab type has many cabs.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cabs()
    {
        return $this->hasMany(Cab::class);
    }
}
