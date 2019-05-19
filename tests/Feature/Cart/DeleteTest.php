<?php

namespace Tests\Feature\Cart;

use Laravel\Passport\Passport;

class DeleteTest extends BaseCart
{
    protected function requestDelete($id)
    {
        return $this->json("DELETE", "/api/cart/{$id}");
    }

    public function testValidShow()
    {
        Passport::actingAs($this->user, ['cart']);
        $cart = $this->user->carts()->firstOrCreate([]);
        $item = $cart->items()->create(["item_id" => $this->item->id]);
        $response = $this->requestDelete($item->id);
        $response->assertJson([
            "success" => true
        ]);
    }

    public function testInvalidItemId()
    {
        Passport::actingAs($this->user, ['cart']);
        $cart = $this->user->carts()->firstOrCreate([]);
        $item = $cart->items()->create(["item_id" => $this->item->id]);
        $response = $this->requestDelete(0);
        $response->assertStatus(404);
    }
}
