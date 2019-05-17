<?php

namespace Tests\Feature\Address;

use Laravel\Passport\Passport;

class IndexTest extends BaseAddress
{
    protected function requestIndex()
    {
        return $this->json('GET', '/api/address');
    }

    public function testIndex()
    {
        Passport::actingAs($this->user, ['address']);
        $response = $this->requestIndex();
        $response->assertJsonStructure(["data" => [['id', 'region', 'city', 'street', 'building', 'apartment']]]);
    }

    public function testUnauthenticated()
    {
        $response = $this->requestIndex();
        $response->assertStatus(401);
    }
}
