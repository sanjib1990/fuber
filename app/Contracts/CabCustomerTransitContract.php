<?php

namespace App\Contracts;

/**
 * Interface CabUserTransitContract
 *
 * @package App\Contracts
 */
interface CabCustomerTransitContract
{
    /**
     * store the transit.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function store(array $data);

    /**
     * Start Transit.
     *
     * @param int $transitId
     *
     * @return mixed
     */
    public function start(int $transitId);

    /**
     * Get list of transits.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function getList(array $data);

    /**
     * Get Transit by id.
     *
     * @param int $transitId
     *
     * @return mixed
     */
    public function getById(int $transitId);

    /**
     * End Transit.
     *
     * @param int $transitId
     *
     * @return mixed
     */
    public function end(int $transitId);
}
