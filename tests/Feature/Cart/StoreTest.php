<?php

namespace Tests\Feature\Cart;

use Laravel\Passport\Passport;

class StoreTest extends BaseCart
{
    protected function requestStore($data)
    {
        return $this->json("POST", "/api/cart", $data);
    }

    public function testValidStore()
    {
        $data = [
            "cart_id" => $this->user->carts()->firstOrCreate([])->id,
            "item_id" => $this->item->id
        ];
        Passport::actingAs($this->user, ['cart']);
        $response = $this->requestStore($data);
        $response->assertJsonStructure([
            "data" => [
                "id", "cart_id", "item", "count"
            ]
        ]);
    }

    public function testUnauthenticatedStore()
    {
        $data = [
            "cart_id" => $this->user->carts()->firstOrCreate([])->id,
            "item_id" => $this->item->id
        ];
        $response = $this->requestStore($data);
        $response->assertStatus(401);
    }

    public function testCountStore()
    {
        $data = [
            "cart_id" => $this->user->carts()->firstOrCreate([])->id,
            "item_id" => $this->item->id,
            "count" => 3
        ];
        Passport::actingAs($this->user, ['cart']);
        $response = $this->requestStore($data);
        $response->assertJson([
            "data" => [
                "count" => 3
            ]
        ]);
    }
}
