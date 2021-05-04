<?php

declare(strict_types=1);

namespace App\Tests\WebTest\Indicated;

use App\Tests\AbstractWebTest;

/**
 * @internal
 * @coversNothing
 */
class IndicatedControllerFailureTest extends AbstractWebTest
{
    /**
     * Test failure new Indicated with error.
     */
    public function testPostIndicatedFailure(): void
    {
        $mock = json_decode(\file_get_contents(__DIR__ . '/Fixtures/testPostIndicatedFailure.json'), true);

        $this->client->xmlHttpRequest(
            'POST',
            $this->router->generate('indicated_new'),
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

        $this->assertArrayHasKey('indicated', $data);
        $this->assertArrayHasKey('id', $data['indicated']);
        $this->assertArrayHasKey('name', $data['indicated']);
        $this->assertArrayHasKey('categories', $data['indicated']);
        $this->assertArrayHasKey('error', $messages);
    }

    /**
     * Test failure delete a Indicated.
     */
    public function testDeleteIndicatedFailure(): void
    {
        $mock = json_decode(\file_get_contents(__DIR__ . '/Fixtures/testDeleteIndicatedFailure.json'), true);

        $this->client->xmlHttpRequest(
            'DELETE',
            $this->router->generate('indicated_delete', [
                'id' => $mock['request']['id'],
            ]),
            [],
            []
        );

        $response = $this->client->getResponse();

        $this->assertSame(404, $response->getStatusCode());
    }
}
