<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class CabApiTest
 *
 * @package Tests\Feature
 */
class CabApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    // URI
    private $uri    = '/api/v1/cabs';

    /**
     * Test get near by api
     *
     * @return void
     *
     * @test
     */
    public function getNearByApi()
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
                    ['id', 'name', 'lat', 'lng', 'available']
                ],
                'message'
            ]);
    }

    /**
     * Test get specific cab
     *
     * @return void
     *
     * @test
     */
    public function getCabByIdApi()
    {
        $this
            ->get($this->uri.'/1')
            ->assertStatus(200)
            ->assertJson([
                'status'    => 'success',
            ])
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id', 'name', 'lat', 'lng', 'available'
                ],
                'message'
            ]);
    }

    /**
     * Test get cab type
     *
     * @return void
     *
     * @test
     */
    public function getCabTypeApi()
    {
        $this
            ->get($this->uri.'/types')
            ->assertStatus(200)
            ->assertJson([
                'status'    => 'success',
            ])
            ->assertJsonStructure([
                'status',
                'data' => [
                    ['id', 'type', 'price_per_km', 'price_per_minute']
                ],
                'message'
            ]);
    }
}
