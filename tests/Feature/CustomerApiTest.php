<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class CustomerApiTest
 *
 * @package Tests\Feature
 */
class CustomerApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    // URI
    private $uri    = '/api/v1/customers';

    /**
     * Test get customer API
     *
     * @return void
     *
     * @test
     */
    public function getCustomers()
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
                    ['id','name','mobile','email','lat','lng']
                ],
                'message'
            ]);
    }

    /**
     * Test customer by id API
     *
     * @return void
     *
     * @test
     */
    public function getCustomerById()
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
                    'id','name','mobile','email','lat','lng'
                ],
                'message'
            ]);
    }
}
