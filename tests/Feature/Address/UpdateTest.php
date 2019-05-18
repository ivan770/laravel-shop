<?php

namespace Tests\Feature\Address;

use Laravel\Passport\Passport;

class UpdateTest extends BaseAddress
{
    protected function requestUpdate($id, $data)
    {
        return $this->json("PUT", "/api/address/{$id}", $data);
    }

    protected function getData()
    {
        return [
            'region' => $this->faker->state,
            'city' => $this->faker->city,
            'street' => $this->faker->streetAddress,
            'building' => $this->faker->randomDigitNotNull,
            'apartment' => $this->faker->randomDigitNotNull
        ];
    }

    public function testValidUpdate()
    {
        $addr_id = $this->address->id;
        Passport::actingAs($this->user, ['address']);
        $response = $this->requestUpdate($addr_id, $this->getData());
        $response->assertJsonStructure([
            "data" => [
                "region", "city", "street", "building", "apartment"
            ]
        ]);
    }

    public function testUnauthenticated()
    {
        $response = $this->requestUpdate($this->address->id, $this->getData());
        $response->assertStatus(401);
    }
}
