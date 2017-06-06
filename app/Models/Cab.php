<?php

namespace App\Models;

use Carbon\Carbon;
use App\Utils\Database;
use App\Contracts\CabContract;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Cab
 *
 * @package App\Models
 */
class Cab extends Model implements CabContract
{
    /**
     * To avoid Mass assignment.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'cab_type_id',
        'base_lat',
        'base_lng',
        'available'
    ];

    /**
     * All the output will be type casted.
     *
     * @var array
     */
    protected $casts    = [
        'available' => 'bool'
    ];

    /**
     * A Cab can have many transits with many different customers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function transits()
    {
        return $this->belongsToMany(Customer::class, 'cab_customer_transits');
    }

    /**
     * A Cab belongs to a type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(CabType::class, 'cab_type_id');
    }

    /**
     * Get all nearby available cabs.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function getNearby(array $data)
    {
        $cabs   = $this
            ->select([
                $this->getTable().'.*',
                $this->getDistanceQuery($data)
            ])
            ->where('available', true);

        if (data_get($data, 'cab_type_id')) {
            $cabs->where('cab_type_id', $data['cab_type_id']);
        }

        return $cabs
            ->having('distance', '<=', data_get($data, 'radius', 5))
            ->orderBy('distance')
            ->get();
    }

    /**
     * Get the distance query.
     *
     * @param array $data
     *
     * @return mixed
     */
    private function getDistanceQuery(array $data)
    {
        $database   = app()->make(Database::class);

        return $database->raw($this->getDistanceString($data).' AS distance');
    }

    /**
     * Get the distance query string.
     *
     * @param array $data
     *
     * @return string
     */
    private function getDistanceString(array $data)
    {
        return "ROUND(SQRT(POWER(base_lat - ".$data['lat'].", 2) + POWER(base_lng - ".$data['lng'].", 2)), 1)";
    }

    /**
     * Get List of cabs.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function getList(array $data)
    {
        $cabs   = $this;

        if (data_get($data, 'available')) {
            $cabs   = $cabs->where('available', true);
        }

        return $cabs->get();
    }

    /**
     * Get specific Cab details.
     *
     * @param int $cabId
     *
     * @return mixed
     */
    public function getById(int $cabId)
    {
        return $this->find($cabId);
    }

    /**
     * Block cab.
     *
     * @param int $cabId
     *
     * @return mixed
     */
    public function block(int $cabId)
    {
        return $this->find($cabId)->update([
            'available'     => false,
            'updated_at'    => Carbon::now()
        ]);
    }

    /**
     * Un Block cab.
     *
     * @param int $cabId
     *
     * @return mixed
     */
    public function unblock(int $cabId)
    {
        return $this->find($cabId)->update([
            'available'     => true,
            'updated_at'    => Carbon::now()
        ]);
    }

    /**
     * Update current location of the cab.
     *
     * @param int   $cabId
     * @param float $lat
     * @param float $lng
     *
     * @return mixed
     */
    public function updateCurrentLocation(int $cabId, float $lat, float $lng)
    {
        return $this->find($cabId)->update([
            'base_lat'      => $lat,
            'base_lng'      => $lng,
            'updated_at'    => Carbon::now()
        ]);
    }
}
