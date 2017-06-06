<?php

namespace App\Contracts;

/**
 * Interface CustomerContract
 *
 * @package App\Contracts
 */
interface CustomerContract
{
    /**
     * Get lis of customers.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function getList(array $data);
}
