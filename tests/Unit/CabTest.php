<?php

namespace Tests\Unit;

use App\Models\Cab;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class CabTest
 *
 * @package Tests\Unit
 */
class CabTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Get nearby function throws an exception if lat lng is not passed
     *
     * @return void
     *
     * @test
     */
    public function nearbyWithoutLatLng()
    {
        $cab    = new Cab();

        $this->expectException(\Exception::class);

        $cab->getNearby([]);
    }

    /**
     * Get nearby function with lat lng works properly
     *
     * @return void
     *
     * @test
     */
    public function nearbyWithLatLng()
    {
        $cab    = new Cab();

        $cab->getNearby(['lat' => 1.1111, 'lng' => 2.111]);
    }

    /**
     * Get nearby should return empty if the lat lng is not within the radius
     *
     * @return void
     *
     * @test
     */
    public function nearbyWithLatLngThatHasNoCabs()
    {
        $cab    = new Cab();

        $cabs   = $cab->getNearby(['lat' => 1000, 'lng' => 2000, 'radius' => 2]);

        $this->assertCount(0, $cabs);
    }

    /**
     * Test the get list function without any filter.
     *
     * @return void
     *
     * @test
     */
    public function getList()
    {
        $availableCount = Cab::count();

        $cab    = new Cab();
        $cabs   = $cab->getList([]);

        $this->assertCount($availableCount, $cabs);
    }

    /**
     * Test the get list function available true.
     *
     * @return void
     *
     * @test
     */
    public function getListWithAvailableCabsOnly()
    {
        $availableCount = Cab::where('available', true)->count();

        $cab    = new Cab();
        $cabs   = $cab->getList(['available' => true]);

        $this->assertCount($availableCount, $cabs);
    }

    /**
     * test Blocking a cab
     *
     * @return void
     *
     * @test
     */
    public function block()
    {
        $cab    = new Cab();

        $cab->block(1);

        $this->assertFalse($cab->getById(1)->available);
    }

    /**
     * Test unblocking a cab
     *
     * @return void
     *
     * @test
     */
    public function unblock()
    {
        $cab    = new Cab();

        $cab->block(1);

        $this->assertFalse($cab->getById(1)->available);

        $cab->unblock(1);

        $this->assertTrue($cab->getById(1)->available);
    }

    /**
     * Test updating current location of a cab
     *
     * @return void
     *
     * @test
     */
    public function updateCurrentLocation()
    {
        $cab    = new Cab();

        $cab->updateCurrentLocation(1, 4.11111, 8.1111);

        $testCab    = $cab->getById(1);

        $this->assertTrue($testCab->base_lat == 4.11111);
        $this->assertTrue($testCab->base_lng == 8.1111);
    }
}
