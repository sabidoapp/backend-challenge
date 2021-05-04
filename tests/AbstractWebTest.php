<?php

declare(strict_types=1);

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\Router;

abstract class AbstractWebTest extends WebTestCase
{
    public static array $defaultHeaders = [
        'CONTENT_TYPE' => 'application/json',
        'ACCEPT' => 'application/json',
    ];

    protected ?KernelBrowser $client;

    protected ?Router $router;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->client = self::createClient(
            [
                'environment' => 'test',
                'debug' => false,
            ]
        );

        $kernel = $this->createKernel();
        $kernel->boot();

        $this->router = $kernel->getContainer()->get('router');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
}
