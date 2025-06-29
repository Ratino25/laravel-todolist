<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    public function testTodolist()
    {
        $this->withSession([
            "user" => "Ratino",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "Ratino"
                ],
                [
                    "id" => "2",
                    "todo" => "April"
                ]
            ]
        ])->get("/todolist")
            ->assertSeeText("1")
            ->assertSeeText("Ratino")
            ->assertSeeText("2")
            ->assertSeeText("April");
    }

    public function testAddTodoFailed()
    {
        $this->withSession([
            "user" => "Ratino",
        ])->post("/todolist", [])
            ->assertSeeText("Todo is required");
    }

    public function testAddTodoSuccess()
    {
        $this->withSession([
            "user" => "Ratino",
        ])->post("/todolist",[
            "todo" => "Ratino"
        ])->assertRedirect("/todolist");
    }


}
