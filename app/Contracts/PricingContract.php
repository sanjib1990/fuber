<?php

namespace App\Contracts;

/**
 * Interface PricingContract
 *
 * @package App\Contracts
 */
interface PricingContract
{
    /**
     * Get distance between coordinates.
     *
     * @return float
     */
    public function getDistance();

    /**
     * Get time difference in minutes.
     *
     * @return int
     */
    public function getTimeInMinutes();

    /**
     * Get calculated price.
     *
     * @return float
     */
    public function getCalculatedPrice();
}
