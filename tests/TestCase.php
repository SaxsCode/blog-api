<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected function actingAsApi(?User $user = null): TestCase
    {
        $user = $user === null ? User::factory()->create() : $user;
        Sanctum::actingAs($user);

        return $this;
    }
}
