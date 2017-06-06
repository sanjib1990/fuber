<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use App\Utils\Pricing;
use App\Models\CabCustomerTransit;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class PricingTest
 *
 * @package Tests\Unit
 */
class PricingTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test Get distance
     *
     * @return void
     *
     * @test
     */
    public function getDistance()
    {
        $from       = [1, 1];
        $toLoc      = [2, 2];
        $distance   = $this->getTestDistance($from, $toLoc);
        $data       = $this->getData($from, $toLoc);

        $transit    = new CabCustomerTransit();
        $created    = $transit->store($data);
        $pricing    = new Pricing($created);

        $this->assertEquals($distance, $pricing->getDistance());
    }

    /**
     * @param $from
     * @param $toLoc
     *
     * @return float
     */
    private function getTestDistance($from, $toLoc)
    {
        return round(sqrt(pow($from[0] - $toLoc[0], 2) + pow($from[1] - $toLoc[1], 2)), 2);
    }

    /**
     * Tets the get time in minutes
     *
     * @return void
     *
     * @test
     */
    public function getTimeInMinutes()
    {
        $from       = [1, 1];
        $toLoc      = [2, 2];
        $data       = $this->getData($from, $toLoc);

        $transit        = new CabCustomerTransit();
        $created        = $transit->store($data);
        $first          = $transit->getById($created->id);
        $diffInMinutes  = 30;

        $first->started_at  = Carbon::now();
        $first->ended_at    = Carbon::parse($first->ended_at)->addMinutes($diffInMinutes);

        $pricing    = new Pricing($first);

        $this->assertEquals($diffInMinutes, $pricing->getTimeInMinutes());
    }

    /**
     * Test calculated price
     *
     * @return void
     *
     * @test
     */
    public function getCalculatedPrice()
    {
        $from       = [1, 1];
        $toLoc      = [2, 2];
        $distance   = $this->getTestDistance($from, $toLoc);
        $data       = $this->getData($from, $toLoc);

        $transit        = new CabCustomerTransit();
        $created        = $transit->store($data);
        $first          = $transit->getById($created->id);
        $diffInMinutes  = 30;

        $first->started_at  = Carbon::now();
        $first->ended_at    = Carbon::parse($first->ended_at)->addMinutes($diffInMinutes);

        $testPrice  = $this->getTestPrice($first, $diffInMinutes, $distance);
        $price      = new Pricing($first);

        $this->assertEquals($testPrice, $price->getCalculatedPrice());
    }

    /**
     * @param $transit
     * @param $diffInMinutes
     * @param $distance
     *
     * @return mixed
     */
    private function getTestPrice($transit, $diffInMinutes, $distance)
    {
        $transit    = $transit->load('cab.type');

        return $distance * $transit->cab->type->price_per_km + $diffInMinutes * $transit->cab->type->price_per_minute;
    }

    /**
     * @param $from
     * @param $toLoc
     *
     * @return array
     */
    private function getData($from, $toLoc)
    {
        return [
            'cab_id'        => 1,
            'customer_id'   => 1,
            'to_lng'        => $toLoc[1],
            'to_lat'        => $toLoc[0],
            'from_lat'      => $from[0],
            'from_lng'      => $from[1],
        ];
    }
}
