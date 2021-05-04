<?php

declare(strict_types=1);

namespace App\Tests\WebTest\Category;

use App\Tests\AbstractWebTest;

/**
 * @internal
 * @coversNothing
 */
class CategoryControllerSuccessTest extends AbstractWebTest
{
    /**
     * Test success list categories.
     */
    public function testGetCategorysSuccess(): void
    {
        $this->client->xmlHttpRequest(
            'GET',
            $this->router->generate('category_index'),
            [],
            []
        );

        $response = $this->client->getResponse();

        $this->assertSame(200, $response->getStatusCode());

        $this->assertTrue(
            $response->headers->contains(
                'Content-Type',
                'application/json'
            )
        );

        ['data' => $data] = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('categories', $data);
    }

    /**
     * Test success new category.
     */
    public function testPostCategorySuccess(): void
    {
        $mock = json_decode(\file_get_contents(__DIR__ . '/Fixtures/testPostCategorySuccess.json'), true);

        $this->client->xmlHttpRequest(
            'POST',
            $this->router->generate('category_new'),
            [],
            [],
            [],
            json_encode($mock['request'])
        );

        $response = $this->client->getResponse();

        $this->assertSame(200, $response->getStatusCode());

        $this->assertTrue(
            $response->headers->contains(
                'Content-Type',
                'application/json'
            )
        );

        $respBody = json_decode($response->getContent(), true);
        ['data' => $data, 'messages' => $messages] = $respBody;

        $this->assertSame($mock['response'], $respBody);

        $this->assertArrayHasKey('category', $data);
        $this->assertArrayHasKey('id', $data['category']);
        $this->assertArrayHasKey('success', $messages);
    }

    /**
     * Test success get category by id.
     */
    public function testGetCategorySuccess(): void
    {
        $mock = json_decode(\file_get_contents(__DIR__ . '/Fixtures/testGetCategorySuccess.json'), true);

        $this->client->xmlHttpRequest(
            'GET',
            $this->router->generate('category_show', [
                'id' => $mock['request']['id'],
            ]),
            [],
            []
        );

        $response = $this->client->getResponse();

        $this->assertSame(200, $response->getStatusCode());

        $this->assertTrue(
            $response->headers->contains(
                'Content-Type',
                'application/json'
            )
        );

        $respBody = json_decode($response->getContent(), true);
        ['data' => $data] = $respBody;

        $this->assertSame($mock['response'], $respBody);

        $this->assertArrayHasKey('id', $data['category']);
    }

    /**
     * Test success update a category.
     */
    public function testPatchCategorySuccess(): void
    {
        $mock = json_decode(\file_get_contents(__DIR__ . '/Fixtures/testPatchCategorySuccess.json'), true);

        $this->client->xmlHttpRequest(
            'PATCH',
            $this->router->generate('category_update', [
                'id' => $mock['request']['id'],
            ]),
            [],
            [],
            [],
            json_encode($mock['request'])
        );

        $response = $this->client->getResponse();

        $this->assertSame(200, $response->getStatusCode());

        $this->assertTrue(
            $response->headers->contains(
                'Content-Type',
                'application/json'
            )
        );

        $respBody = json_decode($response->getContent(), true);
        ['data' => $data, 'messages' => $messages] = $respBody;

        $this->assertSame($mock['response'], $respBody);

        $this->assertArrayHasKey('name', $data['category']);
        $this->assertArrayHasKey('success', $messages);
    }

    /**
     * Test success delete a category.
     */
    public function testDeleteCategorySuccess(): void
    {
        $mock = json_decode(\file_get_contents(__DIR__ . '/Fixtures/testDeleteCategorySuccess.json'), true);

        $this->client->xmlHttpRequest(
            'DELETE',
            $this->router->generate('category_delete', [
                'id' => $mock['request']['id'],
            ]),
            [],
            []
        );

        $response = $this->client->getResponse();

        $this->assertSame(200, $response->getStatusCode());

        $this->assertTrue(
            $response->headers->contains(
                'Content-Type',
                'application/json'
            )
        );

        $respBody = json_decode($response->getContent(), true);
        ['messages' => $messages] = $respBody;

        $this->assertSame($mock['response'], $respBody);

        $this->assertArrayHasKey('success', $messages);
    }
}
