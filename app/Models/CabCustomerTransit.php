<?php

namespace App\Models;

use Carbon\Carbon;
use App\Utils\Pricing;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\CabCustomerTransitContract;

/**
 * Class CabCustomerTransit
 *
 * @package App\Models
 */
class CabCustomerTransit extends Model implements CabCustomerTransitContract
{
    /**
     * To avoid Mass assignment.
     *
     * @var array
     */
    protected $fillable = [
        'cab_id',
        'customer_id',
        'status',
        'to_lng',

        'to_lat',
        'from_lat',
        'from_lng',
        'started_at',

        'ended_at',
        'price'
    ];

    /**
     * A transit belongs to a cab.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cab()
    {
        return $this->belongsTo(Cab::class);
    }

    /**
     * A transit belongs to a customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * store the transit.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function store(array $data)
    {
        return $this->create([
            'cab_id'        => data_get($data, 'cab_id'),
            'customer_id'   => data_get($data, 'customer_id'),
            'status'        => 'confirmed',
            'to_lng'        => data_get($data, 'to_lng'),

            'to_lat'        => data_get($data, 'to_lat'),
            'from_lat'      => data_get($data, 'from_lat'),
            'from_lng'      => data_get($data, 'from_lng'),

            'created_at'    => Carbon::now()
        ]);
    }

    /**
     * Start Transit.
     *
     * @param int $transitId
     *
     * @return mixed
     */
    public function start(int $transitId)
    {
        $transit    = $this->find($transitId);

        if (empty($transit)) {
            return true;
        }

        return $transit->update([
            'started_at'    => Carbon::now(),
            'status'        => 'started',
            'updated_at'    => Carbon::now()
        ]);
    }

    /**
     * Get list of transits.
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
     * Get Transit by id.
     *
     * @param int $transitId
     *
     * @return mixed
     */
    public function getById(int $transitId)
    {
        return $this->find($transitId);
    }

    /**
     * End Transit.
     *
     * @param int $transitId
     *
     * @return mixed
     */
    public function end(int $transitId)
    {
        $transit    = $this->find($transitId);

        if (empty($transit)) {
            return true;
        }

        $pricing    = new Pricing();

        return $this->find($transitId)->update([
            'ended_at'      => Carbon::now(),
            'status'        => 'completed',
            'price'         => $pricing->getCalculatedPrice(),
            'updated_at'    => Carbon::now()
        ]);
    }
}
