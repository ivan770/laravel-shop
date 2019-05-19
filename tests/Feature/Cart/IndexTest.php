<?php

namespace Tests\Feature\Cart;

use Laravel\Passport\Passport;

class IndexTest extends BaseCart
{
    protected function requestIndex()
    {
        return $this->json('GET', '/api/cart');
    }

    public function testIndex()
    {
        Passport::actingAs($this->user, ['cart']);
        $response = $this->requestIndex();
        $response->assertJsonStructure(["data" => [['id', 'status', 'address']]]);
    }

    public function testUnauthenticated()
    {
        $response = $this->requestIndex();
        $response->assertStatus(401);
    }
}
