<?php

namespace Tests\Feature\User;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Client;

class LoginTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @var User $user
     */
    protected $user;

    /**
     * @var Client $client
     */
    protected $client;

    /**
     * @var ClientRepository $passport
     */
    protected $passport;

    protected function logout()
    {
        return $this->post('/logout');
    }

    protected function sendLoginData($email = null, $password = null)
    {
        return $this->json('POST', '/oauth/token', [
            'username' => $email,
            'password' => $password,
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'grant_type' => 'password',
            'scope' => ''
        ]);
    }

    public function setUp() : void
    {
        parent::setUp();
        $this->passport = app(ClientRepository::class);
        $this->client = $this->passport->createPasswordGrantClient(null, "Testing Password Grant Client", 'http://localhost');
        $this->user = factory(User::class)->create();
    }

    public function testValidData()
    {
        $response = $this->sendLoginData($this->user->email, "password");
        $response->assertOk();
    }

    public function testInvalidEmail()
    {
        $response = $this->sendLoginData("invalid@email.com", "password");
        $response->assertStatus(401);
    }

    public function testInvalidPassword()
    {
        $response = $this->sendLoginData($this->user->email, "12345678");
        $response->assertStatus(401);
    }
}
