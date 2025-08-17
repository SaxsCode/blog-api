<?php

namespace Tests\Feature;

use Illuminate\Http\JsonResponse;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    private $validArticleData = [
        'title' => 'Test Article',
        'author' => 'Sax',
        'content' => 'This is test content and I have to be atleast  25 characters long',
    ];

    private $invalidArticleData = [
        'title' => 465,
        'author' => 'Sax',
        'content' => 'test',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAsApi();
    }

    private function createArticle(bool $isValidArticle = true): TestResponse
    {
        $data = $this->validArticleData;
        if (! $isValidArticle) {
            $data = $this->invalidArticleData;
        }

        return $this->postJson(route('articles.store'), $data);
    }

    public function test_can_retrieve_articles(): void
    {
        $this->createArticle();

        $response = $this->getJson(route('articles.index'));

        $response->assertOk()
            ->assertJsonFragment([
                'title' => 'Test Article',
                'author' => 'Sax',
                'content' => 'This is test content and I have to be atleast  25 characters long',
            ]);
    }

    public function test_can_create_article(): void
    {
        $response = $this->createArticle();

        $response->assertCreated()
            ->assertJsonFragment([
                'title' => 'Test Article',
                'author' => 'Sax',
                'content' => 'This is test content and I have to be atleast  25 characters long',
            ]);

    }

    public function test_can_not_create_article_with_invalid_data(): void
    {
        $response = $this->createArticle(false);

        $response->assertUnprocessable();
    }
}
