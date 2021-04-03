<?php

namespace App\Tests\WebTest\Category;

use App\Tests\AbstractWebTest;

class CategoryControllerFailureTest extends AbstractWebTest
{
    /**
     * Test failure new category with error.
     */
    public function testPostCategoryFailure(): void
    {
        $mock = json_decode(\file_get_contents(__DIR__.'/Fixtures/testPostCategoryFailure.json'), true);

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

        $this->assertEquals($mock['response'], $respBody);

        $this->assertArrayHasKey('category', $data);
        $this->assertArrayHasKey('id', $data['category']);
        $this->assertArrayHasKey('name', $data['category']);
        $this->assertArrayHasKey('error', $messages);
    }

    /**
     * Test failure delete a category.
     */
    public function testDeleteCategoryFailure(): void
    {
        $mock = json_decode(\file_get_contents(__DIR__.'/Fixtures/testDeleteCategoryFailure.json'), true);

        $this->client->xmlHttpRequest(
            'DELETE',
            $this->router->generate('category_delete', ['id' => $mock['request']['id']]),
            [],
            []
        );

        $response = $this->client->getResponse();

        $this->assertSame(404, $response->getStatusCode());
    }
}
