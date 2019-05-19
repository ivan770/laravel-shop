<?php

namespace Tests\Unit\Payment;

use App\Contracts\ChargeBuilder;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Item;
use App\Models\Subcategory;
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

    protected $items;

    public function setUp() : void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->cart = $this->user->carts()->create();
        factory(Category::class)->create()->each(function (Category $category) {
            $category->subcategories()->save(factory(Subcategory::class)->make());
        });
        $this->items = Category::first()->subcategories()->first()->items()->saveMany(factory(Item::class, 2)->make());
        $ids = $this->items->map(function ($item, $key) {
            return ["item_id" => $item->id];
        })->toArray();
        $this->cart->items()->createMany($ids);
    }

    public function testValid()
    {
        $builder = app(ChargeBuilder::class);
        $result = $builder->build($this->cart)->calculatePrices()->calculateTotal()->toResult();
        $this->assertSame((float)$this->items->sum("price"), $result["total"]);
    }
}
