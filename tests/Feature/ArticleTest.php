<?php

namespace Tests\Feature;

use Tests\TestCase;

class ArticleTest extends TestCase
{
    public function test_can_create_article(): void
    {
        $response = $this->postJson(route('article.create'));

        $response->assertOk();

    }
}
