<?php

namespace Tests\Unit\Payment;

use App\Contracts\ChargeBuilder;
use App\Exceptions\Payment\EmptyCartCharge;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BuilderTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @var User $user
     */
    protected $user;

    /**
     * @var Cart $cart
     */
    protected $cart;

    protected $emptyCart;

    protected $items;

    public function setUp() : void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->cart = $this->user->carts()->create();
        $this->emptyCart = $this->user->carts()->create();
        factory(Category::class)->create();
        $this->items = Category::first()->items()->saveMany(factory(Item::class, 2)->make());
        $ids = $this->items->map(function ($item, $key) {
            return ["item_id" => $item->id];
        })->toArray();
        $this->cart->items()->createMany($ids);
    }

    public function testValid()
    {
        $builder = app(ChargeBuilder::class);
        $result = $builder->constructOrder($this->cart);
        $this->assertSame((float)$this->items->sum("price"), $result["total"]);
    }

    public function testEmpty()
    {
        $builder = app(ChargeBuilder::class);
        $this->expectException(EmptyCartCharge::class);
        $builder->constructOrder($this->emptyCart);
    }
}
