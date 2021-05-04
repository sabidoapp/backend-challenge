<?php

declare(strict_types=1);

namespace App\Tests\WebTest\Vote;

use App\Tests\AbstractWebTest;

/**
 * @internal
 * @coversNothing
 */
class VoteControllerFailureTest extends AbstractWebTest
{
    /**
     * Test failure new Vote with error.
     */
    public function testPostVoteFailure(): void
    {
        $mock = json_decode(\file_get_contents(__DIR__ . '/Fixtures/testPostVoteFailure.json'), true);

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
        $this->assertArrayHasKey('name', $data['vote']);
        $this->assertArrayHasKey('indicated', $data['vote']);
        $this->assertArrayHasKey('categories', $data['vote']);
        $this->assertArrayHasKey('error', $messages);
    }
}
