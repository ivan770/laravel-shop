<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected function logout()
    {
        return $this->post('/logout');
    }

    protected function sendRegisterData($name = null, $email = null, $password = null)
    {
        return $this->json('POST', '/register', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password
        ]);
    }

    public function testValidData()
    {
        $name = $this->faker->name;
        $email = $this->faker->email;
        $password = $this->faker->password(8);
        $response = $this->sendRegisterData($name, $email, $password);
        $response->assertRedirect();
    }

    public function testShortPassword()
    {
        $name = $this->faker->name;
        $email = $this->faker->email;
        $password = $this->faker->password(2, 4);
        $response = $this->sendRegisterData($name, $email, $password);
        $response->assertJsonValidationErrors(['password']);
    }

    public function testMissingName()
    {
        $email = $this->faker->email;
        $password = $this->faker->password;
        $response = $this->sendRegisterData(null, $email, $password);
        $response->assertJsonValidationErrors(['name']);
    }

    public function testMissingEmail()
    {
        $name = $this->faker->name;
        $password = $this->faker->password;
        $response = $this->sendRegisterData($name, null, $password);
        $response->assertJsonValidationErrors(['email']);
    }

    public function testExistingEmail()
    {
        $password = $this->faker->password;
        $email = $this->faker->email;
        $this->sendRegisterData($email, $password);
        $this->logout();
        $response = $this->sendRegisterData($email, $password);
        $response->assertJsonValidationErrors(['email']);
    }

    public function testMissingPassword()
    {
        $name = $this->faker->name;
        $email = $this->faker->email;
        $response = $this->sendRegisterData($name, $email, null);
        $response->assertJsonValidationErrors(['password']);
    }
}
