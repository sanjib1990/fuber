<?php

namespace App\Contracts;

/**
 * Interface CabContract
 *
 * @package App\Contracts
 */
interface CabContract
{
    /**
     * Get all nearby available cabs.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function getNearby(array $data);

    /**
     * Get List of cabs.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function getList(array $data);

    /**
     * Get specific Cab details.
     *
     * @param int $cabId
     *
     * @return mixed
     */
    public function getById(int $cabId);

    /**
     * Block cab.
     *
     * @param int $cabId
     *
     * @return mixed
     */
    public function block(int $cabId);

    /**
     * Un Block cab.
     *
     * @param int $cabId
     *
     * @return mixed
     */
    public function unblock(int $cabId);

    /**
     * Update current location of the cab.
     *
     * @param int   $cabId
     * @param float $lat
     * @param float $lng
     *
     * @return mixed
     */
    public function updateCurrentLocation(int $cabId, float $lat, float $lng);
}
