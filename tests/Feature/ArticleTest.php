<?php

namespace Tests\Feature;

use Tests\TestCase;

class ArticleTest extends TestCase
{
    public function test_can_create_article(): void
    {
        $this->actingAsApi();
        $data = [
            'title' => 'Test Article',
            'author' => 'Sax',
            'content' => 'This is test content and I have to be atleast  25 characters long',
        ];

        $response = $this->postJson(route('article.create'), $data);

        $response->assertCreated()
            ->assertJsonFragment([
                'title' => 'Test Article',
                'author' => 'Sax',
                'content' => 'This is test content and I have to be atleast  25 characters long',
            ]);

    }
}
