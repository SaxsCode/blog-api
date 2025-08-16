<?php

namespace Tests\Feature;

use Tests\TestCase;

class SanctumTest extends TestCase
{
    public function test_api_can_access_sanctum_route(): void
    {
        $this->actingAsApi();
        $response = $this->getJson(route('authenticated'));
        $response->assertOk();
    }

    public function test_guest_can_not_access_sanctum_route(): void
    {
        $this->actingAsGuest();
        $response = $this->getJson(route('authenticated'));
        $response->assertUnauthorized();
    }
}
