<?php

namespace Tests\Feature;

use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    private const INVALID_ID = 999;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAsApi();
    }

    private function validArticleData(): array
    {
        return [
            'title' => 'Test Article',
            'author' => 'Sax',
            'content' => 'This is test content and I have to be atleast  25 characters long',
        ];
    }

    private function invalidArticleData(): array
    {
        return [
            'title' => 465,
            'author' => 'Sax',
            'content' => 'test',
        ];
    }

    private function postArticle(?array $articleData = null): TestResponse
    {
        if ($articleData === null) {
            $articleData = $this->validArticleData();
        }

        return $this->postJson(route('articles.store'), $articleData);
    }

    public function test_can_retrieve_articles(): void
    {
        $this->postArticle();

        $response = $this->getJson(route('articles.index'));

        $response->assertOk()
            ->assertJsonFragment($this->validArticleData());
    }

    public function test_can_retrieve_specific_article(): void
    {
        $article = $this->postArticle();
        $articleId = $article->json('article.id');

        $response = $this->getJson(route('articles.show', ['article' => $articleId]));

        $response->assertOk()
            ->assertJsonFragment($this->validArticleData());
    }

    public function test_returns_404_retrieving_non_existant_article(): void
    {
        $response = $this->getJson(route('articles.show', ['article' => self::INVALID_ID]));

        $response->assertNotFound();
    }

    public function test_can_create_article(): void
    {
        $response = $this->postArticle();

        $response->assertCreated()
            ->assertJsonFragment($this->validArticleData());

    }

    public function test_article_creation_fails_with_invalid_data(): void
    {
        $response = $this->postArticle($this->invalidArticleData());

        $response->assertUnprocessable();
    }

    public function test_can_update_article(): void
    {
        $article = $this->postArticle();
        $articleId = $article->json('article.id');
        $updatedArticle = ['title' => 'Updated title'];

        $response = $this->patchJson(route('articles.update', ['article' => $articleId]), $updatedArticle);

        $response->assertOk()
            ->assertJsonFragment($updatedArticle);
    }

    public function test_can_not_update_article_with_invalid_data(): void
    {
        $article = $this->postArticle();
        $articleId = $article->json('article.id');
        $updatedArticle = ['title' => self::INVALID_ID];

        $response = $this->patchJson(route('articles.update', ['article' => $articleId]), $updatedArticle);

        $response->assertUnprocessable();
    }

    public function test_can_not_update_non_existant_article(): void
    {
        $updatedArticle = ['title' => 'Updated title'];

        $response = $this->patchJson(route('articles.update', ['article' => self::INVALID_ID]), $updatedArticle);

        $response->assertNotFound();
    }
}
