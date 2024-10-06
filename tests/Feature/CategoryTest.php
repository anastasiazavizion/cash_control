<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Tests\Traits\SetupTrait;

class CategoryTest extends TestCase
{
    use SetupTrait;

    /**
     * A basic feature test example.
     */
    public function test_get_all_categories(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson(route('category.index'));
        $response->assertStatus(200);
        $this->assertJson($response->getContent());

    }
}
