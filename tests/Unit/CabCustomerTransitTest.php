<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\CabCustomerTransit;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class CabCustomerTransitTest
 *
 * @package Tests\Unit
 */
class CabCustomerTransitTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test Store
     *
     * @return void
     *
     * @test
     */
    public function store()
    {
        $transit    = new CabCustomerTransit();
        $data       = [
            'cab_id'        => 1,
            'customer_id'   => 1,
            'to_lng'        => 12.111,
            'to_lat'        => 13.111,
            'from_lat'      => 3.222,
            'from_lng'      => 4.111,
        ];

        $created    = $transit->store($data);
        $fromDB     = $transit->getById($created->id);

        $this->assertNotEmpty($fromDB);
        $this->assertEquals($data['cab_id'], $fromDB->cab_id);
        $this->assertEquals($data['customer_id'], $fromDB->customer_id);
        $this->assertEquals($data['to_lng'], $fromDB->to_lng);
        $this->assertEquals($data['to_lat'], $fromDB->to_lat);
        $this->assertEquals($data['from_lat'], $fromDB->from_lat);
        $this->assertEquals($data['from_lng'], $fromDB->from_lng);
        $this->assertEquals('confirmed', $fromDB->status);
    }

    /**
     * Test Store should throw exception if one or more params is not passed in array
     *
     * @return void
     *
     * @test
     */
    public function storeWithSomeParameterMissing()
    {
        $transit    = new CabCustomerTransit();
        $data       = [
            'cab_id'        => 1,
            'to_lng'        => 12.111,
            'to_lat'        => 13.111,
            'from_lat'      => 3.222,
            'from_lng'      => 4.111,
        ];

        $this->expectException(\PDOException::class);

        $transit->store($data);
    }

    /**
     * Test Start
     *
     * @return void
     *
     * @test
     */
    public function start()
    {
        $transit    = new CabCustomerTransit();
        $data       = [
            'cab_id'        => 1,
            'customer_id'   => 1,
            'to_lng'        => 12.111,
            'to_lat'        => 13.111,
            'from_lat'      => 3.222,
            'from_lng'      => 4.111,
        ];

        $created    = $transit->store($data);
        $transit->start($created->id);
        $fromDb     = $transit->getById($created->id);

        $this->assertEquals('started', $fromDb->status);
    }

    /**
     * Test end
     *
     * @return void
     *
     * @test
     */
    public function end()
    {
        $transit    = new CabCustomerTransit();
        $data       = [
            'cab_id'        => 1,
            'customer_id'   => 1,
            'to_lng'        => 12.111,
            'to_lat'        => 13.111,
            'from_lat'      => 3.222,
            'from_lng'      => 4.111,
        ];

        $created    = $transit->store($data);
        $transit->end($created->id);
        $fromDb     = $transit->getById($created->id);

        $this->assertEquals('completed', $fromDb->status);
        $this->assertNotEmpty($fromDb->price);
    }
}
