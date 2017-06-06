<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Customer;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class CustomerTest
 *
 * @package Tests\Unit
 */
class CustomerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test get list
     *
     * @return void
     *
     * @test
     */
    public function getList()
    {
        $customersCount = Customer::count();

        $customer       = new Customer();

        $this->assertCount($customersCount, $customer->getList([]));
    }

    /**
     * Test get list should throw an exception if no parameters passed.
     *
     * @return void
     *
     * @test
     */
    public function getListWithoutAnyParameters()
    {
        $customer   = new Customer();

        $this->expectException(\TypeError::class);

        $customer->getList();
    }
}
