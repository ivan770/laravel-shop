<?php

namespace Tests\Feature\Address;

use App\Models\Address;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class BaseAddress extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @var User $user
     */
    protected $user;

    /**
     * @var Address $address
     */
    protected $address;

    public function setUp() : void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->address = factory(Address::class)->create(["user_id" => $this->user->id]);
    }
}
