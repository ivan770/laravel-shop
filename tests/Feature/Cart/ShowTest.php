<?php

namespace Tests\Feature\Cart;

use Laravel\Passport\Passport;

class ShowTest extends BaseCart
{
    protected function requestShow($id)
    {
        return $this->json("GET", "/api/cart/{$id}");
    }

    public function testValidShow()
    {
        Passport::actingAs($this->user, ['cart']);
        $cart = $this->user->carts()->firstOrCreate([]);
        $cart->items()->create(["item_id" => $this->item->id]);
        $response = $this->requestShow($cart->id);
        $response->assertJsonStructure([
            "data" => [
                ["id", "cart_id", "item", "count"]
            ]
        ]);
    }

    public function testInvalidId()
    {
        Passport::actingAs($this->user, ['cart']);
        $response = $this->requestShow(0);
        $response->assertStatus(400);
    }
}
