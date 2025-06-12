<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLoginPage()
    {
        $this->get("/login")
            ->assertSeeText("Login");
    }

    public function testLoginPageForMamber()
    {
        $this->withSession([
            "user" => "ratino"
        ])->get("/login")
            ->assertSeeText("/");
    }


    public function testLoginSuccess()
    {
        $this->post("/login", [
            "user" => "ratino",
            "password" => "password"
        ])->assertRedirect("/")
            ->assertSessionHas("user","ratino");
    }

    public function testLoginForUserAlreadyLogin()
    {
        $this->withSession([
            "user" => "ratino"
        ])->post("/login", [
            "user" => "ratino",
            "password" => "password"
        ])->assertRedirect("/");
    }


    public function testLoginValidationError()
    {
        $this->post("/login", [])->assertSeeText("User or password is required");
    }

    public function testLoginFailed()
    {
        $this->post("/login", [
            "user" => "wrong",
            "password" => "wrong"
        ])->assertSeeText("User of password is wrong");
    }

    public function testLogout()
    {
        $this->withSession([
            "user" => "ratino"
        ])->post("/logout")
            ->assertRedirect("/")
            ->assertSessionMissing("user");
    }


}
