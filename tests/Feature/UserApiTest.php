<?php

namespace Tests\Feature;

use app\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    
    use RefreshDatabase;

    public function test_can_create_user() {
        $response = $this->postJson("/api/users", [
            "email" => "tasyanoah@gmail.com",
            "password" => "qwerty123",
            "name" => "Tommy Paul",		
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                    "id", "email", "name", "created_at", "updated_at"
                 ]);
        
        $this->assertDatabaseHas("users", [
            "email" => "tasyanoah@gmail.com",
            "name" => "Tommy Paul",
        ]);
    }

    public function test_can_get_user() {
        User::factory()->count(5)->create();

        $response = $this->getJson("/api/users");

        $response->assertStatus(200)
                 ->assertJsonStructure([
                    "page",
                    "users" => [
                        "*" => ["id", "email", "name", "created_at", "orders_count"]
                    ]
                ]);
        
        $this->assertCount(5, $response->json("users"));
    }

    public function test_can_search_users() {
        User::factory()->create([
            "name" => "Tommy Paul",
            "email" => "tasyanoah@gmail.com"
        ]);

        $response = $this->getJson("/api/users?search=Tommy");

        $response->assertStatus(200)
                 ->assertJsonFragment([
                    "name"=> "Tommy Paul"
                 ]);
    }
}
