<?php

declare(strict_types=1);

namespace App\Tests\WebTest\Vote;

use App\Tests\AbstractWebTest;

/**
 * @internal
 * @coversNothing
 */
class VoteControllerSuccessTest extends AbstractWebTest
{
    /**
     * Test success list votes.
     */
    public function testGetVotesSuccess(): void
    {
        $this->client->xmlHttpRequest(
            'GET',
            $this->router->generate('vote_index'),
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

        $this->assertArrayHasKey('votes', $data);
    }

    /**
     * Test success new Vote.
     */
    public function testPostVoteSuccess(): void
    {
        $mock = json_decode(\file_get_contents(__DIR__ . '/Fixtures/testPostVoteSuccess.json'), true);

        $this->client->xmlHttpRequest(
            'POST',
            $this->router->generate('vote_new'),
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

        $this->assertArrayHasKey('vote', $data);
        $this->assertArrayHasKey('id', $data['vote']);
        $this->assertArrayHasKey('success', $messages);
    }

    /**
     * Test success get Vote by id.
     */
    public function testGetVoteSuccess(): void
    {
        $mock = json_decode(\file_get_contents(__DIR__ . '/Fixtures/testGetVoteSuccess.json'), true);

        $this->client->xmlHttpRequest(
            'GET',
            $this->router->generate('vote_show', [
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

        $this->assertArrayHasKey('id', $data['vote']);
    }
}
