<?php

declare(strict_types=1);

namespace App\Tests\WebTest;

use App\Tests\AbstractWebTest;

/**
 * @internal
 * @coversNothing
 */
class IndexControllerSuccessTest extends AbstractWebTest
{
    /**
     * Test API index.
     */
    public function testIndex(): void
    {
        $this->client->xmlHttpRequest('GET', $this->router->generate('index'));

        $response = $this->client->getResponse();

        $this->assertSame(200, $response->getStatusCode());

        $this->assertTrue(
            $response->headers->contains(
                'Content-Type',
                'application/json'
            )
        );

        ['messages' => $messages] = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('info', $messages);
    }
}
