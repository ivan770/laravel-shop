<?php

namespace Tests\Feature\Address;

use Laravel\Passport\Passport;

class StoreTest extends BaseAddress
{
    protected function requestStore($data)
    {
        return $this->json("POST", "/api/address", $data);
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

    public function testValidStore()
    {
        Passport::actingAs($this->user, ['address']);
        $response = $this->requestStore($this->getData());
        $response->assertJsonStructure([
            "data" => [
                "region", "city", "street", "building", "apartment"
            ]
        ]);
    }

    public function testUnauthenticated()
    {
        $response = $this->requestStore($this->getData());
        $response->assertStatus(401);
    }
}
