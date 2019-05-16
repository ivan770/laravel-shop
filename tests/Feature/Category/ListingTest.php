<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;

class ListingTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @var User $user
     */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        factory(Category::class)->create()->each(function ($category) {
            $category->subcategories()->save(factory(Subcategory::class)->make());
        });
    }

    protected function requestListing()
    {
        return $this->json('GET', '/api/category');
    }

    public function testListing()
    {
        Passport::actingAs($this->user);
        $response = $this->requestListing();
        $response->assertJsonStructure(["data" => [["id", "subcategories"]]]);
    }

    public function testWithoutAuth()
    {
        $response = $this->requestListing();
        $response->assertStatus(401);
    }
}
