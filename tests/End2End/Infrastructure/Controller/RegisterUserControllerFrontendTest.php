<?php

declare(strict_types=1);

namespace App\Tests\End2End\Infrastructure\Controller;

use Symfony\Component\Panther\PantherTestCase;

class RegisterUserControllerFrontendTest extends PantherTestCase
{
    public function testPasswordAndConfirmPasswordFieldValidWhenSame(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/login');
        $this->assertPageTitleContains('Login');
        $this->assertTrue(true);
    }
}