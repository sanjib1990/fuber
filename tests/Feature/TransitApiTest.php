<?php

namespace Tests\Feature;

use App\Models\CabCustomerTransit;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class TransitApiTest
 *
 * @package Tests\Feature
 */
class TransitApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    // URI
    private $uri    = '/api/v1/cabs/transits';

    /**
     * Test Get list of transits
     *
     * @return void
     *
     * @test
     */
    public function getAllTransitsApi()
    {
        $this
            ->get($this->uri)
            ->assertStatus(200)
            ->assertJson([
                'status'    => 'success',
            ])
            ->assertJsonStructure([
                'status',
                'data' => [
                    ['id', 'to_lng', 'to_lat', 'from_lat', 'from_lng', 'started_at', 'ended_at', 'status', 'price']
                ],
                'message'
            ]);
    }

    /**
     * Test get speific transit api
     *
     * @return void
     *
     * @test
     */
    public function getSpecificTransitsApi()
    {
        $transitId  = $this->getTransitId();

        $this
            ->get($this->uri.'/'.$transitId)
            ->assertStatus(200)
            ->assertJson([
                'status'    => 'success',
            ])
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id', 'to_lng', 'to_lat', 'from_lat', 'from_lng', 'started_at', 'ended_at', 'status', 'price'
                ],
                'message'
            ]);
    }

    /**
     * Get Transit ID.
     *
     * @return mixed
     */
    private function getTransitId()
    {
        $transit    = CabCustomerTransit::first();

        if (empty($transit)) {
            $transit    = CabCustomerTransit::create([
                'cab_id'        => 1,
                'customer_id'   => 1,
                'status'        => 'confirmed',
                'to_lng'        => 1,

                'to_lat'        => 1,
                'from_lat'      => 2,
                'from_lng'      => 2,

                'created_at'    => Carbon::now()
            ]);
        }

        return $transit->id;
    }

    /**
     * Test book api with null cab id
     *
     * @return void
     *
     * @test
     */
    public function bookWithInvalidInput()
    {
        $this
            ->assertForNullCabId()
            ->assertForNullCustomerId()
            ->assertForNullFromLat()
            ->assertForNullFromLng()
            ->assertForNullToLat()
            ->assertForNullToLng();
    }

    /**
     * @return $this
     */
    private function assertForNullCabId()
    {
        $this
            ->post(
                '/api/v1/cabs/book',
                [
                    "customer_id"   => 1,
                    "cab_id"        => null,
                    "from_lat"      => 1.1,
                    "from_lng"      => 1.1,
                    "to_lat"        =>1.1,
                    "to_lng"        => 1.1,
                ]
            )
            ->assertStatus(400)
            ->assertJson([
                'status'    => 'fail',
            ]);

        return $this;
    }

    /**
     * @return $this
     */
    private function assertForNullCustomerId()
    {
        $this
            ->post(
                '/api/v1/cabs/book',
                [
                    "customer_id"   => null,
                    "cab_id"        => 1,
                    "from_lat"      => 1.1,
                    "from_lng"      => 1.1,
                    "to_lat"        =>1.1,
                    "to_lng"        => 1.1,
                ]
            )
            ->assertStatus(400)
            ->assertJson([
                'status'    => 'fail',
            ]);

        return $this;
    }

    /**
     * @return $this
     */
    private function assertForNullFromLat()
    {
        $this
            ->post(
                '/api/v1/cabs/book',
                [
                    "customer_id"   => 1,
                    "cab_id"        => 1,
                    "from_lat"      => null,
                    "from_lng"      => 1.1,
                    "to_lat"        =>1.1,
                    "to_lng"        => 1.1,
                ]
            )
            ->assertStatus(400)
            ->assertJson([
                'status'    => 'fail',
            ]);

        return $this;
    }

    /**
     * @return $this
     */
    private function assertForNullFromLng()
    {
        $this
            ->post(
                '/api/v1/cabs/book',
                [
                    "customer_id"   => 1,
                    "cab_id"        => 1,
                    "from_lat"      => 1.1,
                    "from_lng"      => null,
                    "to_lat"        =>1.1,
                    "to_lng"        => 1.1,
                ]
            )
            ->assertStatus(400)
            ->assertJson([
                'status'    => 'fail',
            ]);

        return $this;
    }

    /**
     * @return $this
     */
    private function assertForNullToLat()
    {
        $this
            ->post(
                '/api/v1/cabs/book',
                [
                    "customer_id"   => 1,
                    "cab_id"        => 1,
                    "from_lat"      => 1.1,
                    "from_lng"      => 1.1,
                    "to_lat"        => null,
                    "to_lng"        => 1.1,
                ]
            )
            ->assertStatus(400)
            ->assertJson([
                'status'    => 'fail',
            ]);

        return $this;
    }

    /**
     * @return $this
     */
    private function assertForNullToLng()
    {
        $this
            ->post(
                '/api/v1/cabs/book',
                [
                    "customer_id"   => 1,
                    "cab_id"        => 1,
                    "from_lat"      => 1.1,
                    "from_lng"      => 1.1,
                    "to_lat"        => 1.1,
                    "to_lng"        => null,
                ]
            )
            ->assertStatus(400)
            ->assertJson([
                'status'    => 'fail',
            ]);

        return $this;
    }

    /**
     * Book Cab with valid inputs
     *
     * @return void
     *
     * @test
     */
    public function bookWithValidInputs()
    {
        $response   = $this
            ->post(
                '/api/v1/cabs/book',
                [
                    "customer_id"   => 1,
                    "cab_id"        => 1,
                    "from_lat"      => 1.1,
                    "from_lng"      => 1.1,
                    "to_lat"        =>1.1,
                    "to_lng"        => 1.1,
                ]
            );

        $response
            ->assertStatus(201)
            ->assertJson([
                'status'    => 'success',
            ])
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id', 'to_lng', 'to_lat', 'from_lat', 'from_lng', 'started_at', 'ended_at', 'status', 'price'
                ],
                'message'
            ]);

        $transitId  = $response->decodeResponseJson()['data']['id'];
        $transit    = CabCustomerTransit::find($transitId);

        $this->assertNotEmpty($transit);
    }

    /**
     * Test start API
     *
     * @return void
     *
     * @test
     */
    public function startApi()
    {
        $transitId  = $this->getTransitId();

        $this->patch($this->uri.'/'.$transitId.'/start')->assertStatus(205);

        $fromDb = CabCustomerTransit::find($transitId);

        $this->assertNotNull($fromDb->started_at);
    }

    /**
     * Test start API
     *
     * @return void
     *
     * @test
     */
    public function endApi()
    {
        $transitId  = $this->getTransitId();

        $this->patch($this->uri.'/'.$transitId.'/end')->assertStatus(205);

        $fromDb = CabCustomerTransit::find($transitId);

        $this->assertNotNull($fromDb->ended_at);
    }
}
