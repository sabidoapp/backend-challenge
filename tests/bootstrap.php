<?php

declare(strict_types=1);

use App\Kernel;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

if (file_exists(dirname(__DIR__) . '/config/bootstrap.php')) {
    require dirname(__DIR__) . '/config/bootstrap.php';
} elseif (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->usePutenv(true)->loadEnv(dirname(__DIR__) . '/.env.test');
}

/**
 * For load database schema, migrations and fixtures and use transaction on tests.
 */
function bootstrap(): void
{
    $kernel = new Kernel('test', false);
    $kernel->boot();

    $application = new Application($kernel);
    $application->setAutoExit(false);

    try {
        // clearing test cache.
        $application->run(
            new ArrayInput(
                [
                    'cache:clear',
                    '--env' => 'test',
                    '--no-interaction' => null,
                ]
            )
        );

        // doctrine ORM
        $application->run(
            new ArrayInput(
                [
                    'doctrine:cache:clear-metadata',
                    '--env' => 'test',
                    '--no-interaction' => null,
                    '--no-debug' => null,
                ]
            )
        );

        $application->run(
            new ArrayInput(
                [
                    'doctrine:database:drop',
                    '--if-exists' => '1',
                    '--env' => 'test',
                    '--force' => null,
                    '--no-interaction' => null,
                    '--no-debug' => null,
                ]
            )
        );

        $application->run(
            new ArrayInput(
                [
                    'doctrine:database:create',
                    '--env' => 'test',
                    '--no-interaction' => null,
                    '--no-debug' => null,
                ]
            )
        );

        $application->run(
            new ArrayInput(
                [
                    'doctrine:migrations:migrate',
                    '--env' => 'test',
                    '--allow-no-migration' => null,
                    '--no-interaction' => null,
                    '--no-debug' => null,
                ]
            )
        );

        $application->run(
            new ArrayInput(
                [
                    'doctrine:fixtures:load',
                    '--env' => 'test',
                    '--no-interaction' => null,
                    '--no-debug' => null,
                ]
            )
        );
    } catch (\Exception $e) {
        throw $e;
    }

    $kernel->shutdown();
}

bootstrap();
