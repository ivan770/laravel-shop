<?php

namespace Tests\Feature\Cart;

use App\Models\Category;
use App\Models\Item;
use App\Models\Subcategory;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class BaseCart extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @var User $user
     */
    protected $user;

    /**
     * @var Item $item
     */
    protected $item;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->user->carts()->create();
        factory(Category::class)->create()->each(function (Category $category) {
            $category->subcategories()->save(factory(Subcategory::class)->make());
        });
        $this->item = Category::first()->subcategories()->first()->items()->save(factory(Item::class)->make());
    }
}
