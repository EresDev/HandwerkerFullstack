<?php

declare(strict_types=1);

namespace App\Tests\Shared;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as SymfonyWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class WebTestCase extends SymfonyWebTestCase
{
    protected KernelBrowser $client;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->client = static::createClient([], ['HTTPS' => true]);
    }

    protected function makeClientForHttp(): void
    {
        $this->client = static::createClient([], ['HTTPS' => false]);
    }

    protected function getService(string $className): object
    {
        return self::$container->get($className);
    }

    protected function response(): Response
    {
        return $this->client->getResponse();
    }

    protected function request(
        string $method,
        string $uri,
        array $parameters = [],
        array $files = [],
        array $server = [],
        string $content = null,
        bool $changeHistory = true
    ): void
    {
        $this->client->request(
            $method,
            $uri,
            $parameters,
            $files,
            $server,
            $content,
            $changeHistory
        );
    }
}
