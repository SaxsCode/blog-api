<?php

namespace Tests\Feature;

use Tests\TestCase;

class ArticleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAsApi();
    }

    public function test_can_retrieve_articles(): void
    {
        $response = $this->getJson(route('article.view'));

        $response->assertOk()
            ->assertJsonFragment([
                'title' => 'Test Article',
                'author' => 'Sax',
                'content' => 'This is test content and I have to be atleast  25 characters long',
            ]);
    }

    public function test_can_create_article(): void
    {
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

    public function test_can_not_create_article_with_invalid_data(): void
    {
        $invalidData = [
            'title' => 465,
            'author' => 'Sax',
            'content' => 'test',
        ];

        $response = $this->postJson(route('article.create'), $invalidData);

        $response->assertUnprocessable();
    }
}
