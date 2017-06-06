<?php

namespace App\Models;

use App\Contracts\CustomerContract;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Customer
 *
 * @package App\Models
 */
class Customer extends Model implements CustomerContract
{
    /**
     * To avoid Mass assignment.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'mobile',
        'email',
        'base_lat',
        'base_lng'
    ];

    /**
     * A user may have many transits with many different cabs.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function transits()
    {
        return $this->belongsToMany(Cab::class, 'cab_customer_transits');
    }

    /**
     * Get lis of customers.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function getList(array $data)
    {
        return $this->get();
    }

    /**
     * Get Customer by id.
     *
     * @param int $customerId
     *
     * @return mixed
     */
    public function getById(int $customerId)
    {
        return  $this->find($customerId);
    }
}
