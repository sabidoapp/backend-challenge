<?php

declare(strict_types=1);

namespace App\Tests\WebTest\Indicated;

use App\Tests\AbstractWebTest;

/**
 * @internal
 * @coversNothing
 */
class IndicatedControllerSuccessTest extends AbstractWebTest
{
    /**
     * Test success list nominated.
     */
    public function testGetCitiesSuccess(): void
    {
        $this->client->xmlHttpRequest(
            'GET',
            $this->router->generate('indicated_index'),
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

        $this->assertArrayHasKey('nominated', $data);
    }

    /**
     * Test success new Indicated.
     */
    public function testPostIndicatedSuccess(): void
    {
        $mock = json_decode(\file_get_contents(__DIR__ . '/Fixtures/testPostIndicatedSuccess.json'), true);

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
        $this->assertArrayHasKey('success', $messages);
    }

    /**
     * Test success get Indicated by id.
     */
    public function testGetIndicatedSuccess(): void
    {
        $mock = json_decode(\file_get_contents(__DIR__ . '/Fixtures/testGetIndicatedSuccess.json'), true);

        $this->client->xmlHttpRequest(
            'GET',
            $this->router->generate('indicated_show', [
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

        $this->assertArrayHasKey('id', $data['indicated']);
    }

    /**
     * Test success update a Indicated.
     */
    public function testPatchIndicatedSuccess(): void
    {
        $mock = json_decode(\file_get_contents(__DIR__ . '/Fixtures/testPatchIndicatedSuccess.json'), true);

        $this->client->xmlHttpRequest(
            'PATCH',
            $this->router->generate('indicated_update', [
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

        $this->assertArrayHasKey('name', $data['indicated']);
        $this->assertArrayHasKey('success', $messages);
    }

    /**
     * Test success delete a Indicated.
     */
    public function testDeleteIndicatedSuccess(): void
    {
        $mock = json_decode(\file_get_contents(__DIR__ . '/Fixtures/testDeleteIndicatedSuccess.json'), true);

        $this->client->xmlHttpRequest(
            'DELETE',
            $this->router->generate('indicated_delete', [
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
